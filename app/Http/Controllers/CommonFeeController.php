<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class CommonFeeController extends Controller
{
    //Function for monthly paid fees
    public function monthly_paid_fees() {
        //Get current month and year
        $currentMonth = Carbon::now()->format('F');
        $currentYear = Carbon::now()->format('Y');
        //Get users
        $students = User::orderBy('id', 'ASC')
            ->where('user_type', 'Student')
            ->where('user_status', 'Active')
            ->with('student_fees_detail')
            ->get();
        //Get start and end month
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();
     
        $totalPaidCurrentMonth = 0;
        $totalRemainingFees = 0;
        //record
        $reportData = [];
        //duration
        $courseDurationMonths = [
            '1 Year' => 12,
            '2 Year' => 24,
            '3 Month' => 3,
            '6 Month' => 6,
            '1 Month' => 1,
        ];
        //Get students fees
        foreach ($students as $student) {
            $totalFees = (float) $student->total_fees;
            $totalPaidAllMonths = (float) $student->student_fees_detail->sum('user_fees');
            //Current month fees
            $currentMonthFees = $student->student_fees_detail
                ->whereBetween('submission_date', [$startOfMonth, $endOfMonth])
                ->pluck('user_fees')
                ->toArray();
            //Check if no payment in current month
            if (empty($currentMonthFees)) {
                continue; 
            }
            //Get payment
            $paymentTypes = $student->student_fees_detail
                ->whereBetween('submission_date', [$startOfMonth, $endOfMonth])
                ->pluck('payment_type')
                ->unique()
                ->implode('/');
            //Formating
            $formattedFees = count($currentMonthFees) > 1
                ? implode('/', array_map(fn($f) => number_format($f), $currentMonthFees)) . ' = ' . number_format(array_sum($currentMonthFees))
                : number_format($currentMonthFees[0]);
            //Remaining fees
            $remainingFees = max(0, $totalFees - $totalPaidAllMonths);
            //Feepercentage
            $feePercentage = isset($courseDurationMonths[$student->course_duration])
                ? round(($totalFees - $student->student_fees_detail->where('is_down_payment', 'down_payment')->sum('user_fees')) / $courseDurationMonths[$student->course_duration])
                : 0;
            //totalpaid
            $totalPaidCurrentMonth += array_sum($currentMonthFees);
            //remainign
            $totalRemainingFees += $remainingFees;
            
            $reportData[] = [
                'id' => $student->id,
                'name' => $student->name,
                'phone' => $student->father_phone_no ?? '-',
                'formattedFees' => $formattedFees,
                'paymentTypes' => $paymentTypes,
                'remainingFees' => $remainingFees,
                'lastSubmissionDate' => optional($student->student_fees_detail->sortByDesc('submission_date')->first())->submission_date,
                'monthlyFee' => $feePercentage,
                'status' => 'Paid',
            ];
        }
        //response
        return view('export.paid-fees', compact(
            'currentMonth',
            'currentYear',
            'reportData',
            'totalPaidCurrentMonth',
            'totalRemainingFees'
        ));
    }

    //Function for monthly pending fees
    public function monthly_pending_fees() {
        //Get current month and year
        $currentMonth = Carbon::now()->format('F');
        $currentYear = Carbon::now()->format('Y');
        //Get start and end month
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();
        //Check condition
        $last31Days = Carbon::now()->subDays(31)->toDateString();
        $last55Days = Carbon::now()->subDays(55)->toDateString();

        //Get students
        $students = User::orderBy('id', 'ASC')
            ->where('user_type', 'Student')
            ->where('user_status', 'Active')
            ->where(function ($query) use ($last31Days, $last55Days) {
                $query->whereHas('student_fees_detail', function ($subQuery) use ($last31Days, $last55Days) {
                    $subQuery->whereBetween('submission_date', [$last55Days, $last31Days]);
                })
                ->orWhereDoesntHave('student_fees_detail');
            })
            //Students who HAVE NOT paid in current month
            ->whereDoesntHave('student_fees_detail', function ($query) use ($startOfMonth) {
                $query->where('submission_date', '>=', $startOfMonth);
            })
            //Get fees detail
            ->with(['student_fees_detail' => function ($q) {
                $q->orderBy('submission_date', 'desc');
            }])
            ->get();

        //Get data
        $reportData = [];
        $totalLastPaidFees = 0;
        $totalRemainingFees = 0;
        //Duration
        $courseDurationMonths = [
            '1 Year' => 12,
            '2 Year' => 24,
            '3 Month' => 3,
            '6 Month' => 6,
            '1 Month' => 1,
        ];
        //Get fees details
        foreach ($students as $student) {
            $totalFees = (float) $student->total_fees;
            $totalPaid = (float) $student->student_fees_detail->sum('user_fees');
            //Get last payment data
            $lastPayment = $student->student_fees_detail->first();
            $lastFeeAmount = (float)($lastPayment->user_fees ?? 0);
            $lastPaymentType = $lastPayment->payment_type ?? '-';
            $lastSubmissionDate = $lastPayment->submission_date ?? 'No fees paid in any month';
            //Down payment
            $downPayment = $student->student_fees_detail
                ->where('is_down_payment', 'down_payment')
                ->sum('user_fees');
            //Remaining fees
            $remainingFees = max(0, $totalFees - $totalPaid);
            //Get monthly fees
            if (isset($courseDurationMonths[$student->course_duration])) {
                $monthlyFee = round(($totalFees - $downPayment) / $courseDurationMonths[$student->course_duration]);
            } else {
                $monthlyFee = 0;
            }
            //Totals
            $totalLastPaidFees += $lastFeeAmount;
            $totalRemainingFees += $remainingFees;

            //Get students details
            $reportData[] = [
                'id' => $student->id,
                'name' => $student->name,
                'phone' => $student->father_phone_no ?? '-',
                'formattedFees' => number_format($lastFeeAmount),
                'paymentTypes' => $lastPaymentType,
                'remainingFees' => $remainingFees,
                'lastSubmissionDate' => $lastSubmissionDate,
                'monthlyFee' => $monthlyFee,
                'status' => 'Pending',
            ];
        }
        //response
        return view('export.pending-fees', compact(
            'currentMonth',
            'currentYear',
            'reportData',
            'totalLastPaidFees',
            'totalRemainingFees'
        ));
    }

    //Function for overdue fees
    public function overdue_fees() {
        //Get current month and year
        $currentMonth = Carbon::now()->format('F');
        $currentYear = Carbon::now()->format('Y');
        $last58Days = Carbon::now()->subDays(56)->toDateString();
        //Get students detail
        $students = User::orderBy('id', 'ASC')
            ->where('user_type', 'Student')
            ->where('user_status', 'Active')
            ->whereHas('student_fees_detail', function ($query) use ($last58Days) {
                $query->where('submission_date', '<', $last58Days);
            })
            ->with(['student_fees_detail' => function ($query) {
                $query->orderBy('submission_date', 'desc');
            }])
            ->get();
        //Reports data
        $reportData = [];
        $totalLastPaidFees = 0;
        $totalRemainingFees = 0;
        //Get students
        foreach ($students as $student) {
            //Get last payment
            $lastPayment = $student->student_fees_detail->first();
            if (!$lastPayment) continue;
   
            if (Carbon::parse($lastPayment->submission_date)->gt($last58Days)) {
                continue;
            }

            $lastSubmissionDate = $lastPayment->submission_date ?? 'Overdue';
            $lastFees = $lastPayment->user_fees ?? 0;
            $paymentType = $lastPayment->payment_type ?? 'N/A';
            $totalFees = $student->total_fees;
            //Down Payment
            $downPayment = $student->student_fees_detail
                ->where('is_down_payment', 'down_payment')
                ->first()
                ->user_fees ?? 0;
            //Total paid
            $totalPaidFees = $student->student_fees_detail->sum('user_fees');
            $remainingFees = max(0, $totalFees - $totalPaidFees);
            //Monthly fee calculation
            $difference = $totalFees - $downPayment;
            //Get month
            $monthlyFee = match ($student->course_duration) {
                '1 Year' => $difference / 12,
                '2 Year' => $difference / 24,
                '3 Month' => $difference / 3,
                '6 Month' => $difference / 6,
                '1 Month' => $difference / 1,
                default => 0
            };
            //Get reports
            $reportData[] = [
                'id' => $student->id,
                'name' => $student->name,
                'phone' => $student->father_phone_no ?? '-',
                'formattedFees' => number_format($lastFees),
                'paymentTypes' => $paymentType,
                'remainingFees' => $remainingFees,
                'lastSubmissionDate' => $lastSubmissionDate,
                'monthlyFee' => $monthlyFee,
                'status' => 'Overdue',
            ];
            //Get last fees
            $totalLastPaidFees += $lastFees;
            //Get
            $totalRemainingFees += $remainingFees;
        }

        return view('export.overdue-fees', compact(
            'reportData',
            'currentMonth',
            'currentYear',
            'totalLastPaidFees',
            'totalRemainingFees'
        ));
    }
}