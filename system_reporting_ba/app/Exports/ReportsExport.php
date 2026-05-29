<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    use Exportable;

    private $request;
    private $totalQty = 0;
    private $totalSales = 0;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Report::with(['user.rbs', 'distributor', 'province', 'city', 'outlet', 'brand', 'product']);

        if ($this->request->filled('start_date')) {
            $query->whereDate('date', '>=', $this->request->start_date);
        }

        if ($this->request->filled('end_date')) {
            $query->whereDate('date', '<=', $this->request->end_date);
        }

        if ($this->request->filled('distributor_id')) {
            $query->where('distributor_id', $this->request->distributor_id);
        }

        if ($this->request->filled('user_id')) {
            $selectedUser = \App\Models\User::find($this->request->user_id);
            
            if ($selectedUser && $selectedUser->role === 'ba') {
                $assignedOutletIds = $selectedUser->outlets->pluck('id')->toArray();
                if ($this->request->filled('outlet_id')) {
                    $query->where('outlet_id', $this->request->outlet_id);
                } else {
                    $query->whereIn('outlet_id', $assignedOutletIds);
                }
                $query->where('user_id', $selectedUser->id);
            } else {
                $query->where('user_id', $this->request->user_id);
                if ($this->request->filled('outlet_id')) {
                    $query->where('outlet_id', $this->request->outlet_id);
                }
            }
        } elseif ($this->request->filled('outlet_id')) {
            $query->where('outlet_id', $this->request->outlet_id);
        }

        if ($this->request->filled('user_name')) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->request->user_name . '%');
            });
        }

        $reports = $query->latest()->get();

        // Calculate Totals
        $this->totalQty = $reports->sum('quantity');
        $this->totalSales = $reports->sum('total_price');

        // Add a "Total" row to the collection
        // We use a simple array or object that mapping can handle
        $reports->push((object)[
            'is_total_row' => true,
            'total_qty' => $this->totalQty,
            'total_sales' => $this->totalSales
        ]);

        return $reports;
    }

    public function headings(): array
    {
        return [
            'ID',
            'ID Transaksi',
            'Tanggal',
            'Nama BA',
            'Atasan',
            'Distributor',
            'Account Type',
            'Channel',
            'Provinsi',
            'Kota',
            'Toko',
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
        if (isset($report->is_total_row)) {
            return [
                'TOTAL',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                $report->total_qty,
                '',
                '',
                '',
                $report->total_sales
            ];
        }

        return [
            $report->id,
            $report->group_id ?? '-',
            $report->date,
            optional($report->user)->name ?? 'N/A',
            optional($report->user->rbs)->name ?? '-',
            optional($report->distributor)->name ?? 'N/A',
            $report->account_type ?? '-',
            $report->channel ?? '-',
            optional($report->province)->name ?? '-',
            optional($report->city)->name ?? '-',
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
        $lastRow = $sheet->getHighestRow();

        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF4F81BD'],
                ],
            ],
            $lastRow => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFFFFF00'], // Yellow for total row
                ],
            ],
        ];
    }
}
