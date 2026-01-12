<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $employees = User::with(['roles:id,name'])->role('driver');

        if ($request->search) {
            $employees->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('phone', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        $perPage = $request->get('per_page', 10);
        $employees = $employees->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();

        return view('dashboard.employee.index', compact('employees'));
    }

    public function form(User $employee)
    {
        if ($employee->id && $employee->roles->first()->name != 'driver') {
            abort(404);
        }

        return view('dashboard.employee.form', [
            'employee' => $employee->id ? $employee : null,
        ]);
    }

    public function store(EmployeeFormRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }
        $user = User::create($data);
        $user->assignRole('driver');
        return redirect()->route('employee')->with('success', 'Karyawan berhasil ditambahkan');
    }

    public function update(EmployeeFormRequest $request, User $employee)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            if ($employee->image) {
                Storage::delete($employee->image);
            }
            $data['image'] = $request->file('image')->store('images', 'public');
        }
        $employee->update($data);
        return redirect()->route('employee')->with('success', 'Karyawan berhasil diubah');
    }

    public function statusToggle(User $employee)
    {
        $employee->update(['status' => $employee->status == 'active' ? 'inactive' : 'active']);
        return back()->with('success', 'Status karyawan berhasil diubah');
    }

    public function show(User $employee)
    {
        // Ensure employee has driver role
        if (!$employee->hasRole('driver')) {
            abort(404);
        }

        // Load relationships
        $employee->load(['roles']);

        // Get statistics
        $totalSchedules = \App\Models\Schedule::where('driver_id', $employee->id)->count();
        $totalReceipts = \App\Models\Receipt::where('user_id', $employee->id)->count();
        $totalAttendances = \App\Models\Attendance::where('user_id', $employee->id)->count();
        $totalReceiptAmount = \App\Models\Receipt::where('user_id', $employee->id)->sum('amount');

        // Get recent schedules
        $recentSchedules = \App\Models\Schedule::where('driver_id', $employee->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get recent receipts
        $recentReceipts = \App\Models\Receipt::where('user_id', $employee->id)
            ->with('schedule:id,customer_name')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.employee.detail', compact(
            'employee',
            'totalSchedules',
            'totalReceipts',
            'totalAttendances',
            'totalReceiptAmount',
            'recentSchedules',
            'recentReceipts'
        ));
    }
}
