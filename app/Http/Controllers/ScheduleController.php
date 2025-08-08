<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use App\Http\Requests\ScheduleFormRequest;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $schedules = Schedule::with('driver');

        if ($request->has('search')) {
            $schedules->where('customer_name', 'like', '%' . $request->search . '%')
                ->orWhere('customer_phone', 'like', '%' . $request->search . '%')
                ->orWhere('start_location', 'like', '%' . $request->search . '%')
                ->orWhere('end_location', 'like', '%' . $request->search . '%')
                ->orWhereHas('driver', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                });
        }
        if ($request->has('start_date') && $request->has('end_date')) {
            $schedules->where('start_date', '>=', $request->start_date)->where('end_date', '<=', $request->end_date);
        }

        $schedules = $schedules->paginate(10);

        return view('dashboard.schedule.index', compact('schedules'));
    }

    public function form(Schedule $schedule)
    {
        $drivers = User::where('status', 'active')->role('driver')->get();
        return view('dashboard.schedule.form', ['schedule' => $schedule->id ? $schedule : null, 'drivers' => $drivers]);
    }

    public function store(ScheduleFormRequest $request)
    {
        $data = $request->validated();
        $data['status'] = 'pending';

        Schedule::create($data);
        Session::flash('timeout', 0);
        return back()->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function update(ScheduleFormRequest $request, Schedule $schedule)
    {
        $schedule->update($request->validated());
        return redirect()->route('schedule')->with('success', 'Jadwal berhasil diubah');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('schedule')->with('success', 'Jadwal berhasil dihapus');
    }

    public function detail(Schedule $schedule)
    {
        return view('dashboard.schedule.detail', compact('schedule'));
    }

    public function getDriverSchedules(Request $request)
    {
        $userId = auth()->user()->id;
        $schedules = Schedule::with('attendances')
            ->whereDoesntHave('attendances', function ($query) {
                $query->where('type', 'out');
            })
            ->where('driver_id', $userId)
            ->orderBy($request->type == 'in' ? 'start_date' : 'end_date', 'desc')
            ->get();

        $schedules = $schedules->map(function ($schedule) {
            $schedule->type = $schedule->attendances->first() ? $schedule->attendances->first()->type : null;
            return $schedule;
        })->filter(function ($schedule) use ($request) {
            return $request->type == 'in' ? $schedule->type == null : $schedule->type == 'in';
        });

        return view('mobile.attendance.schedule', compact('schedules'));
    }
}
