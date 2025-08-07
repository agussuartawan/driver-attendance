<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function index(Request $request)
    {
        $receipts = Receipt::with('user')->orderBy('date', 'desc');
        if ($request->has('start_date') && $request->has('end_date')) {
            $receipts->whereBetween('date', [$request->start_date, $request->end_date]);
        }
        if ($request->has('search')) {
            $receipts->where('user.name', 'like', '%' . $request->search . '%');
        }

        $receipts = $receipts->paginate(10);

        return view('dashboard.receipt.index', compact('receipts'));
    }
}
