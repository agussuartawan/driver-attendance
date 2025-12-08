<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\Schedule;
use App\Events\ReceiptCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\UploadService;
use Carbon\Carbon;

class ReceiptController extends Controller
{
    protected $uploadService;
    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    public function index()
    {
        // Get receipt statistics
        $totalUploads = Receipt::where('user_id', Auth::id())->count();
        $monthlyUploads = Receipt::where('user_id', Auth::id())
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Get recent receipts
        $recentReceipts = Receipt::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('mobile.receipt.index', compact('totalUploads', 'monthlyUploads', 'recentReceipts'));
    }

    public function add()
    {
        $schedules = Schedule::where('driver_id', Auth::id())->get();
        $schedules = $schedules->map(function ($schedule) {
            $schedule->name = $schedule->customer_name . ' | ' . Carbon::parse($schedule->start_date)->format('d/m/Y H:i') . ' - ' . Carbon::parse($schedule->end_date)->format('d/m/Y H:i');
            return $schedule;
        });

        return view('mobile.receipt.add', compact('schedules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string|max:100',
            'schedule_id' => 'required|exists:schedules,id',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $image = $request->file('image');
        $filePath = $this->uploadService->upload($image, 'receipts');

        $receipt = Receipt::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'category' => $request->category,
            'image' => $filePath,
            'date' => now(),
            'schedule_id' => $request->schedule_id,
        ]);

        event(new ReceiptCreated($receipt));

        return redirect()->route('mobile.receipt')->with('success', 'Nota biaya berhasil diupload');
    }

    public function history()
    {
        $receipts = Receipt::with('schedule:id,customer_name')->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Calculate additional statistics
        $monthlyCount = Receipt::where('user_id', Auth::id())
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $totalAmount = Receipt::where('user_id', Auth::id())
            ->sum('amount');

        return view('mobile.receipt.history', compact('receipts', 'monthlyCount', 'totalAmount'));
    }

    public function show(Receipt $receipt)
    {
        // Ensure user can only view their own receipts
        if ($receipt->user_id !== Auth::id()) {
            abort(403);
        }

        return view('mobile.receipt.show', compact('receipt'));
    }

    public function destroy(Receipt $receipt)
    {
        // Ensure user can only delete their own receipts
        if ($receipt->user_id !== Auth::id()) {
            abort(403);
        }

        // Delete file from storage
        $this->uploadService->delete($receipt->image);

        $receipt->delete();

        return redirect()->route('mobile.receipt.history')->with('success', 'Nota biaya berhasil dihapus');
    }

    public function dashboard(Request $request)
    {
        $receipts = Receipt::with('user:id,name')->with('schedule:id,customer_name')->orderBy('created_at', 'desc');

        if ($request->has('search')) {
            $receipts->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->has('start_date') && $request->start_date) {
            $receipts->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $receipts->whereDate('created_at', '<=', $request->end_date);
        }

        $receipts = $receipts->paginate(10);

        return view('dashboard.receipt.index', compact('receipts'));
    }

    public function showDashboard(Receipt $receipt)
    {
        $receipt->load(['user', 'schedule']);

        return view('dashboard.receipt.detail', compact('receipt'));
    }
}
