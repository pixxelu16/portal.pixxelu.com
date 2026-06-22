<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportStudents;
use App\Exports\ExportTrashStudents;
use App\Exports\PaidExportStudentsFees;
use App\Exports\PendingExportStudentsFees; 
use App\Exports\OverdueExportStudentsFees; 


class ExportStudentController extends Controller
{
    //Function for export students record
    public function export_students(Request $request) {
        //Get request inputs
        $courseType = $request->get('course_type', 'all');

        return Excel::download(new ExportStudents($courseType), 'all_students_list.xlsx');
    }

    //Function for export trash students record
    public function export_trash_students(Request $request) {
        //Get request for inputs fileds 
        $user_status = $request->get('user_status', 'all');
        return Excel::download(new ExportTrashStudents($user_status), 'all_trash_students_list.xlsx');
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

    //Function for export students overdue pending fees record
    public function export_students_overdue_fees() {
        $export = new OverdueExportStudentsFees();
        return Excel::download($export, 'students_overdue_fees_' . now()->format('F_Y') . '.xlsx');
    }
}
