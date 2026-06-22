<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\User;
use App\Models\StudentFees;

class StudentFeesPdfController extends Controller
{
    //Function for create student fees pdf
    public function downloadReceipt($student_id)  {
        //Get student detail
        $student = User::with('student_fees_detail')->findOrFail($student_id);

        //Get current month & year
        $currentMonth = Carbon::now()->format('F Y');
        $currentYear = Carbon::now()->format('Y');

        //Get total course fees
        $totalFees = $student->total_fees;

        //Get all fees paid
        $totalFeesPaid = $student->student_fees_detail->sum('user_fees');

        //Calculate remaining fees
        $remainingFees = $totalFees - $totalFeesPaid;

        //Get the last paid record
        $lastPaidRecord = $student->student_fees_detail->sortByDesc('submission_date')->first();
        $lastPaidAmount = $lastPaidRecord ? $lastPaidRecord->user_fees : 0;
        $lastPaidMonth = $lastPaidRecord ? Carbon::parse($lastPaidRecord->submission_date)->format('F Y') : 'N/A';

        //Get all monthly payments
        $monthlyFees = $student->student_fees_detail->sortBy('submission_date');

        $data = [
            'student' => $student,
            'totalFees' => $totalFees,
            'totalFeesPaid' => $totalFeesPaid,
            'remainingFees' => $remainingFees,
            'lastPaidAmount' => $lastPaidAmount,
            'lastPaidMonth' => $lastPaidMonth,
            'monthlyFees' => $monthlyFees,
            'month' => $currentMonth,
        ];

        //Create pdf
        $pdf = PDF::loadView('admin.students.student-fees-receipt-pdf', $data)
            ->setPaper('A4', 'portrait'); 

        //Generate file name
        $fileName = 'receipt_' . $student->name . '_' . Carbon::now()->format('d M Y') . '.pdf';

        //Save PDF to the folder
        $pdf->save(public_path("uploads/student-monthly-fees-pdf/{$fileName}"));

        //Download the PDF
        return $pdf->download($fileName);   
    }

    //Fucntion for show attendance monthly sheet 
    public function downloadAttendancePDF(Request $request) {
        //Get input field type
        $type = $request->type;
        //Get data and month
        $date = Carbon::now()->startOfMonth();
        $daysInMonth = $date->daysInMonth;
        //Curse duration filter
        if ($type === 'regular') {
            $courseDurations = ['1 Year', '2 Year', '3 Year', '4 Year'];
            $attendanceTitle = 'Regular Students Attendance Sheet';
        } else {
            $courseDurations = ['1 Month', '3 Month', '6 Month'];
            $attendanceTitle = 'Internship Students Attendance Sheet';
        }
        //Get students
        $students = User::where('user_type', 'Student')
            ->where('user_status', 'Active')
            ->whereIn('course_duration', $courseDurations)
            ->orderBy('id', 'asc')
            ->get();
        //Pdf
        $pdf = Pdf::setOptions([
            'enable_html5_parser' => true,
            'enable_php' => true,
            'isRemoteEnabled' => true
        ])->loadView('admin.students.student-attendance-pdf', [
            'date'     => $date,
            'days'     => $daysInMonth,
            'students' => $students,
            'attendanceTitle' => $attendanceTitle
        ]);
        //Pdf size
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download(
            strtolower($request->type) . '_attendance_' . $date->format('F_Y') . '.pdf'
        );
    }
}
