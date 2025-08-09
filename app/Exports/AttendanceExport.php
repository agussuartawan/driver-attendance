<?php

namespace App\Exports;

use App\Models\Attendance;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Attendance::with('employee')->orderBy('date', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Karyawan',
            'Tanggal',
            'Tipe',
            'Lokasi',
            'Kordinat',
            'Bukti',
            'Status'
        ];
    }

    public function map($attendance): array
    {
        return [
            $attendance->id,
            $attendance->employee->name ?? 'N/A',
            $attendance->date,
            $attendance->type,
            $attendance->location,
            $attendance->latitude . ', ' . $attendance->longitude,
            url(Storage::url($attendance->image)),
            $attendance->status == 'on_time' ? 'Tepat Waktu' : ($attendance->status == 'late' ? 'Terlambat' : 'Terlalu Awal')
        ];
    }
}
