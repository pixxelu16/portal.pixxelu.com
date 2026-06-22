<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportInquery;
class ExportInqueryController extends Controller
{
    //Function for export students record
    public function export_inqueries(Request $request) {
        //Get input request course_type
        $course_type = $request->course_type;
       //echo $course_type;exit;
        return Excel::download(new ExportInquery($course_type), 'all_inqueries_list.xlsx');
    }
}
