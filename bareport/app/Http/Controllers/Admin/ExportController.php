<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\ReportsExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function reports(Request $request)
    {
        $format = $request->query('format', 'xlsx');

        // Generate a more descriptive filename based on filters
        $filename = "reports";
        if ($request->filled('start_date')) {
            $filename .= "_" . $request->start_date;
        }
        if ($request->filled('end_date')) {
            $filename .= "_to_" . $request->end_date;
        }
        if (!$request->filled('start_date') && !$request->filled('end_date')) {
            $filename .= "_all_" . date('Ymd_His');
        }

        if ($format === 'csv') {
            return Excel::download(new ReportsExport($request), $filename . '.csv', \Maatwebsite\Excel\Excel::CSV);
        }

        return Excel::download(new ReportsExport($request), $filename . '.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
