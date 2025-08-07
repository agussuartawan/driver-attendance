<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Exports\AttendanceExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AttendanceController extends Controller
{
    public function report(Request $request)
    {
        $attendances = Attendance::with('employee')->orderBy('date', 'desc');

        if ($request->has('start_date') && $request->has('end_date')) {
            $attendances->whereBetween('date', [$request->start_date, $request->end_date]);
        }
        if ($request->has('search')) {
            $attendances->where('employee.name', 'like', '%' . $request->search . '%');
        }

        $attendances = $attendances->paginate(10);

        return view('dashboard.report.attendance', compact('attendances'));
    }

    public function export()
    {
        return Excel::download(new AttendanceExport, 'attendance.xlsx');
    }
}
