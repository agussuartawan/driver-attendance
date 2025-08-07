<?php

namespace App\Exports;

use App\Models\Attendance;
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
            'Waktu',
            'Created At',
            'Updated At'
        ];
    }

    public function map($attendance): array
    {
        return [
            $attendance->id,
            $attendance->employee->name ?? 'N/A',
            $attendance->date,
            $attendance->type,
            $attendance->time,
            $attendance->created_at,
            $attendance->updated_at
        ];
    }
}
