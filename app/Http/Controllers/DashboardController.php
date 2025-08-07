<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Receipt;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalDriver = User::with(['roles:id,name'])->role('driver')->count();
        $totalSchedule = Schedule::count();
        $receipts = Receipt::select('amount', 'category')->get();
        $attendances = Attendance::select('date', 'type')->get();

        $totalReceipt = $receipts->sum('amount');

        // Data untuk bar chart absensi per tahun (12 bulan)
        $attendanceData = [];
        $currentYear = Carbon::now()->year;

        for ($month = 1; $month <= 12; $month++) {
            $startDate = Carbon::create($currentYear, $month, 1)->format('Y-m-d');
            $endDate = Carbon::create($currentYear, $month, 1)->endOfMonth()->format('Y-m-d');

            $monthAttendances = $attendances->filter(function ($attendance) use ($startDate, $endDate) {
                return $attendance->date >= $startDate && $attendance->date <= $endDate;
            });

            $attendanceData[] = [
                'month' => Carbon::create($currentYear, $month, 1)->format('M'),
                'monthName' => Carbon::create($currentYear, $month, 1)->format('F'),
                'in' => $monthAttendances->where('type', 'in')->count(),
                'out' => $monthAttendances->where('type', 'out')->count(),
                'total' => $monthAttendances->count(),
            ];
        }

        // Data untuk pie chart receipt berdasarkan kategori
        $receiptCategories = $receipts->groupBy('category')->map(function ($group) use ($totalReceipt) {
            return [
                'category' => $group->first()->category,
                'total' => $group->sum('amount'),
                'percentage' => $totalReceipt > 0 ? round(($group->sum('amount') / $totalReceipt) * 100, 1) : 0,
            ];
        })->values()->toArray();

        return view('dashboard.index', [
            'totalDriver' => $totalDriver,
            'totalSchedule' => $totalSchedule,
            'totalReceipt' => $totalReceipt,
            'attendanceData' => $attendanceData,
            'receiptCategories' => $receiptCategories,
            'currentYear' => $currentYear,
        ]);
    }
}
