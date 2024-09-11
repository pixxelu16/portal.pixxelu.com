<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportStudents;
use App\Exports\PaidExportStudentsFees;
use App\Exports\PendingExportStudentsFees; 

class ExportStudentController extends Controller
{
    //Function for export students record
    public function export_students() {
        return Excel::download(new ExportStudents, 'all_students_list.xlsx');
    }

    //Function for export students monthly paid fees record
    public function export_students_paid_fees() {
        $export = new PaidExportStudentsFees();
        return Excel::download($export, 'students_paid_fees_' . now()->format('F_Y') . '.xlsx');
    }

    //Function for export students monthly pending fees record
    public function export_students_pending_fees() {
        $export = new PendingExportStudentsFees();
        return Excel::download($export, 'students_pending_fees_' . now()->format('F_Y') . '.xlsx');
    }
}
