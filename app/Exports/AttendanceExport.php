<?php

namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    use Exportable;

    protected $fromDate;
    protected $toDate;
    protected $userId;

    public function __construct($fromDate, $toDate, $userId = null)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
        $this->userId = $userId;
    }

    public function query()
    {
        $query = Attendance::with(['user.distributor', 'outlet', 'attendanceRequest']);

        if ($this->fromDate) {
            $query->whereDate('date', '>=', $this->fromDate);
        }

        if ($this->toDate) {
            $query->whereDate('date', '<=', $this->toDate);
        }

        if ($this->userId) {
            $query->where('user_id', $this->userId);
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            'No.',
            'Tanggal',
            'Waktu',
            'Tipe Absen',
            'Nama BA',
            'Toko / Outlet',
            'Distributor',
            'Koordinat (Lat, Lng)',
            'Sumber Data',
            'Keterangan (Alasan)'
        ];
    }

    public function map($attendance): array
    {
        static $rowNumber = 0;
        $rowNumber++;

        // Cek apakah data berasal dari pengajuan manual
        $source = $attendance->attendance_request_id ? 'PENGAJUAN MANUAL' : 'SISTEM (GPS)';
        $reason = $attendance->attendanceRequest->reason ?? '-';
        $coordinates = $attendance->attendance_request_id ? '-' : ($attendance->latitude . ', ' . $attendance->longitude);

        // Jika pengajuan berasal dari sistem (auto Missed Attendance track)
        if ($attendance->attendance_request_id && in_array($reason, ['Alpha', 'Tidak Check-out'])) {
            $source = 'SISTEM (OTOMATIS)';
        }

        return [
            $rowNumber,
            date('d-m-Y', strtotime($attendance->date)),
            date('H:i', strtotime($attendance->time)),
            strtoupper($attendance->type),
            optional($attendance->user)->name ?? '-',
            optional($attendance->outlet)->name ?? '-',
            optional($attendance->user->distributor)->name ?? 'Internal',
            $coordinates,
            $source,
            $reason
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
