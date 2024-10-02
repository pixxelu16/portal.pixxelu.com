<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportInquery;
class ExportInqueryController extends Controller
{
    //Function for export students record
    public function export_inqueries() {
        return Excel::download(new ExportInquery, 'all_inqueries_list.xlsx');
    }
}
