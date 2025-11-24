<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Exports\AttendanceExport;
use App\Events\AttendanceCreated;
use App\Http\Requests\AttendanceRequest;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Services\UploadService;

class AttendanceController extends Controller
{
    protected $uploadService;
    public function __construct(UploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    public function report(Request $request)
    {
        $attendances = Attendance::with([
            'employee:id,name',
            'schedule:id,customer_name',
            'schedule.receipts',
        ])->orderBy('date', 'desc');

        if ($request->has('start_date') && $request->has('end_date')) {
            $attendances->whereBetween('date', [$request->start_date, $request->end_date]);
        }
        if ($request->has('search')) {
            $attendances->whereHas('employee', function($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            });
        }

        $attendances = $attendances->paginate(10);

        $grouped = $attendances->getCollection()
            ->groupBy('schedule_id')
            ->map(function ($items) {
                $in  = $items->firstWhere('type', 'in');
                $out = $items->firstWhere('type', 'out');
                $firstItem = optional($items)->first();
                $totalReceiptAmount = $items->first()->schedule->receipts->sum('amount');

                return [
                    'schedule_id'   => $firstItem?->schedule_id,
                    'customer'      => $firstItem?->schedule?->customer_name,

                    'date'          => optional($in?->date)->format('Y-m-d'),
                    'start'         => optional($in?->date)->format('H:i'),
                    'end'           => optional($out?->date)->format('H:i'),

                    'location'      => $in->location ?? null,
                    'start_latitude'  => $in->latitude ?? null,
                    'start_longitude' => $in->longitude ?? null,
                    'end_latitude'    => $out->latitude ?? null,
                    'end_longitude'   => $out->longitude ?? null,

                    'is_start_location_exists' => !empty($in?->latitude) && !empty($in?->longitude),
                    'is_end_location_exists'   => !empty($out?->latitude) && !empty($out?->longitude),

                    'status'        => $in->status ?? null,
                    'employee'      => $firstItem?->employee?->name,

                    'total_receipt_amount' => $totalReceiptAmount,

                    'start_image'   => $in->image ?? null,
                    'end_image'     => $out->image ?? null,
                ];
            })
            ->values();

        $attendances->setCollection($grouped);

        return view('dashboard.report.attendance', compact('attendances'));
    }

    public function export()
    {
        return Excel::download(new AttendanceExport, 'attendance.xlsx');
    }

    public function store(AttendanceRequest $request, $type, Schedule $schedule)
    {
        $data = $request->validated();

        $data['status'] = ($type == 'in')
            ? ($schedule->start_date > now() ? 'on_time' : 'late')
            : ($schedule->end_date < now() ? 'on_time' : 'early');

        $data['schedule_id'] = $schedule->id;
        $data['user_id'] = Auth::id();
        $data['type'] = $type;
        $data['date'] = now();

        // Simpan image dari data URL base64
        $imageDataUrl = $data['image'];
        // Format: data:image/jpeg;base64,xxxxxxxx
        [$meta, $content] = explode(',', $imageDataUrl, 2);
        // Tentukan ekstensi dari mime
        $extension = 'jpg';
        if (str_starts_with($meta, 'data:image/png')) $extension = 'png';
        elseif (str_starts_with($meta, 'data:image/gif')) $extension = 'gif';
        elseif (str_starts_with($meta, 'data:image/svg')) $extension = 'svg';

        $binary = base64_decode($content);
        $data['image'] = $this->uploadService->upload($binary, "attendance");

        $attendance = Attendance::create($data);
        $schedule->update(['status' => $type == 'in' ? 'in_progress' : 'completed']);

        event(new AttendanceCreated($attendance));

        return redirect()->route('mobile.attendance')->with('success', 'Berhasil melakukan absensi');
    }

    public function form($type, Schedule $schedule)
    {
        $now = now();
        if ($type == 'in') {
            // Untuk type 'in', tidak boleh ada attendance type 'in' untuk schedule ini
            if ($schedule->attendances()->where('type', 'in')->exists()) abort(404);

            $isDanger = $now->gt($schedule->start_date);
            $status = $isDanger ? 'Terlambat' : 'Tepat Waktu';
        } else {
            // Untuk type 'out', harus ada attendance type 'in' terlebih dahulu
            if (!$schedule->attendances()->where('type', 'in')->exists()) abort(404);

            // Dan tidak boleh ada attendance type 'out' untuk schedule ini
            if ($schedule->attendances()->where('type', 'out')->exists()) abort(404);

            $isDanger = $now->lt($schedule->end_date);
            $status = $isDanger ? 'Terlalu Awal' : 'Tepat Waktu';
        }
        return view('mobile.attendance.form', compact('schedule', 'isDanger', 'status', 'type'));
    }

    public function getDriverAttendance(Request $request)
    {
        // Ambil semua attendance dengan eager loading
        $attendances = Attendance::with(['employee:id,name', 'schedule:id,customer_name,start_date,end_date'])
            ->where('user_id', Auth::id())
            ->orderBy('date', 'desc');

        // Filter berdasarkan tanggal jika ada
        if ($request->has('start_date') && $request->start_date) {
            $attendances->whereDate('date', '>=', $request->start_date);
        }
        if ($request->has('end_date') && $request->end_date) {
            $attendances->whereDate('date', '<=', $request->end_date);
        }

        // Validasi: end_date tidak boleh lebih kecil dari start_date
        if ($request->start_date && $request->end_date && $request->start_date > $request->end_date) {
            return redirect()->route('mobile.attendance.history')
                ->with('error', 'Tanggal akhir tidak boleh lebih kecil dari tanggal awal');
        }

        // Filter berdasarkan nama customer jika ada
        if ($request->has('search')) {
            $attendances->whereHas('schedule', function($query) use ($request) {
                $query->where('customer_name', 'like', '%' . $request->search . '%');
            });
        }

        // Ambil data dan group berdasarkan schedule_id
        $groupedAttendances = $attendances->get()
            ->groupBy('schedule_id')
            ->map(function ($scheduleAttendances) {
                // Ambil attendance 'in' dan 'out' untuk schedule ini
                $inAttendance = $scheduleAttendances->where('type', 'in')->first();
                $outAttendance = $scheduleAttendances->where('type', 'out')->first();

                // Gunakan attendance 'in' sebagai base data
                $baseAttendance = $inAttendance ?: $outAttendance;

                if (!$baseAttendance) {
                    return null;
                }

                // Parse tanggal
                $baseAttendance->date = \Carbon\Carbon::parse($baseAttendance->date);

                // Set properti yang diperlukan
                $baseAttendance->day = $baseAttendance->date->isToday() ? 'Hari Ini' : $baseAttendance->date->translatedFormat('l');
                $baseAttendance->customer = $baseAttendance->schedule->customer_name;
                $baseAttendance->in = $inAttendance;
                $baseAttendance->out = $outAttendance;

                // Set waktu dan status untuk in attendance
                if ($inAttendance) {
                    $baseAttendance->start_time = \Carbon\Carbon::parse($inAttendance->date)->format('H:i');
                    $baseAttendance->start_status = $inAttendance->status;
                    $baseAttendance->start_image = $inAttendance->image;
                } else {
                    $baseAttendance->start_time = '-';
                    $baseAttendance->start_status = '-';
                    $baseAttendance->start_image = null;
                }

                // Set waktu dan status untuk out attendance
                if ($outAttendance) {
                    $baseAttendance->end_time = \Carbon\Carbon::parse($outAttendance->date)->format('H:i');
                    $baseAttendance->end_status = $outAttendance->status;
                    $baseAttendance->end_image = $outAttendance->image;
                } else {
                    $baseAttendance->end_time = '-';
                    $baseAttendance->end_status = '-';
                    $baseAttendance->end_image = null;
                }

                // Hitung durasi berdasarkan start dan end attendance
                if ($inAttendance && $outAttendance) {
                    $startTime = \Carbon\Carbon::parse($inAttendance->date);
                    $endTime = \Carbon\Carbon::parse($outAttendance->date);
                    $diff = $startTime->diff($endTime);

                    $parts = [];
                    if ($diff->d > 0) {
                        $parts[] = $diff->d . ' hari';
                    }
                    if ($diff->h > 0) {
                        $parts[] = $diff->h . ' jam';
                    }
                    if ($diff->i > 0) {
                        $parts[] = $diff->i . ' menit';
                    }
                    if (empty($parts)) {
                        $parts[] = '0 menit';
                    }
                    $baseAttendance->duration = implode(' ', $parts);
                } else {
                    $baseAttendance->duration = '-';
                }

                return $baseAttendance;
            })
            ->filter() // Hapus null values
            ->values(); // Reset array keys

        return view('mobile.attendance.history', [
            'attendances' => $groupedAttendances,
        ]);
    }

    public function driverHome(Request $request)
    {
        $scheduleController = new ScheduleController();
        $recentSchedule = $scheduleController->getRecentSchedule();

        // Hitung total jam kerja
        $attendances = Attendance::where('user_id', Auth::id())
            ->with('schedule')
            ->orderBy('date', 'desc')
            ->get();

        $totalWorkingHours = 0;
        $totalDeliveries = 0;

        // Group by schedule_id dan hitung jam kerja per schedule
        $groupedAttendances = $attendances->groupBy('schedule_id');

        foreach ($groupedAttendances as $scheduleId => $scheduleAttendances) {
            $inAttendance = $scheduleAttendances->where('type', 'in')->first();
            $outAttendance = $scheduleAttendances->where('type', 'out')->first();

            // Hanya hitung jika ada in dan out attendance
            if ($inAttendance && $outAttendance) {
                $startTime = \Carbon\Carbon::parse($inAttendance->date);
                $endTime = \Carbon\Carbon::parse($outAttendance->date);

                // Hitung durasi dalam jam (dengan decimal)
                $durationInHours = $startTime->diffInMinutes($endTime) / 60;
                $totalWorkingHours += $durationInHours;
                $totalDeliveries++;
            }
        }

        // Format jam kerja
        $workingHoursFormatted = '';
        $totalHours = (int) $totalWorkingHours;
        $totalMinutes = (int) (($totalWorkingHours - $totalHours) * 60);

        if ($totalHours > 0) {
            $workingHoursFormatted .= $totalHours . 'j ';
        }
        if ($totalMinutes > 0) {
            $workingHoursFormatted .= $totalMinutes . 'm';
        }
        if (empty($workingHoursFormatted)) {
            $workingHoursFormatted = '0j';
        }

        return view('mobile.attendance.index', compact('recentSchedule', 'workingHoursFormatted', 'totalDeliveries'));
    }
}
