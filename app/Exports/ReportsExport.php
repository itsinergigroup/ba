<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportsExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    use Exportable;

    private $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Report::with(['user', 'distributor', 'outlet', 'brand', 'product']);

        if ($this->request->filled('start_date')) {
            $query->whereDate('date', '>=', $this->request->start_date);
        }

        if ($this->request->filled('end_date')) {
            $query->whereDate('date', '<=', $this->request->end_date);
        }

        if ($this->request->filled('distributor_id')) {
            $query->where('distributor_id', $this->request->distributor_id);
        }

        if ($this->request->filled('outlet_id')) {
            $query->where('outlet_id', $this->request->outlet_id);
        }

        if ($this->request->filled('user_id')) {
            $query->where('user_id', $this->request->user_id);
        }

        if ($this->request->filled('user_name')) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->request->user_name . '%');
            });
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            'ID',
            'ID Transaksi',
            'Tanggal',
            'BA Name',
            'Distributor',
            'Account Type',
            'Channel',
            'Outlet',
            'Brand',
            'Product',
            'QTY',
            'HET',
            'Unit Price',
            'Discount %',
            'Total Price'
        ];
    }

    public function map($report): array
    {
        return [
            $report->id,
            $report->group_id ?? '-',
            $report->date,
            optional($report->user)->name ?? 'N/A',
            optional($report->distributor)->name ?? 'N/A',
            $report->account_type ?? '-',
            $report->channel ?? '-',
            optional($report->outlet)->name ?? 'N/A',
            optional($report->brand)->name ?? 'N/A',
            optional($report->product)->name ?? 'N/A',
            $report->quantity ?? 0,
            round($report->het ?? 0),
            round($report->unit_price ?? 0),
            round($report->discount ?? 0, 2),
            round($report->total_price ?? 0)
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as header
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => 'FFFFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF4F81BD'], // Professional Blue
                ],
            ],
        ];
    }
}
