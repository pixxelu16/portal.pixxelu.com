<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\StudentFees;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $filterType = $request->get('filter_type', 'month');
        if (!in_array($filterType, ['year', 'month', 'week'])) {
            $filterType = 'month';
        }

        $selectedYear  = (int) $request->get('year', date('Y'));
        $selectedMonth = (int) $request->get('month', date('n'));
        $selectedWeek  = (int) $request->get('week', Carbon::now()->weekOfYear);

        $selectedMonth = max(1, min(12, $selectedMonth));
        $selectedWeek  = max(1, min(53, $selectedWeek));

        [$periodStart, $periodEnd, $periodLabel] = $this->resolvePeriod(
            $filterType,
            $selectedYear,
            $selectedMonth,
            $selectedWeek
        );

        $all_students_total_fees = User::where('user_status', 'Active')->sum('total_fees');
        $all_students_paid_fees  = StudentFees::where('user_status', 'Active')->sum('user_fees');

        $periodPaidFees = StudentFees::where('user_status', 'Active')
            ->whereBetween('submission_date', [$periodStart, $periodEnd])
            ->sum('user_fees');

        $payment_type_online = StudentFees::where('user_status', 'Active')
            ->where('payment_type', 'online')
            ->whereBetween('submission_date', [$periodStart, $periodEnd])
            ->sum('user_fees');

        $payment_type_cash = StudentFees::where('user_status', 'Active')
            ->where('payment_type', 'cash')
            ->whereBetween('submission_date', [$periodStart, $periodEnd])
            ->sum('user_fees');

        $get_student_list = User::where('user_status', 'Active')
            ->whereHas('student_fees_detail', function ($query) use ($periodStart, $periodEnd) {
                $query->whereBetween('submission_date', [$periodStart, $periodEnd]);
            })
            ->with(['student_fees_detail' => function ($query) use ($periodStart, $periodEnd) {
                $query->whereBetween('submission_date', [$periodStart, $periodEnd])
                    ->orderBy('submission_date', 'desc');
            }])
            ->get()
            ->sortByDesc(function ($user) {
                return $user->student_fees_detail->first()->submission_date ?? null;
            });

        $monthlyFees = $this->getMonthlyFeesForYear($selectedYear);
        $year_total_fees = array_sum($monthlyFees);

        $enrollmentYears = range(2023, (int) date('Y'));
        $enrollmentData  = $this->getEnrollmentData($enrollmentYears);

        $weekChartData = [];
        if ($filterType === 'week') {
            $weekChartData = $this->getDailyFeesForWeek($selectedYear, $selectedWeek);
        }

        $monthChartData = [];
        if ($filterType === 'month') {
            $monthChartData = $this->getDailyFeesForMonth($selectedYear, $selectedMonth);
        }

        $is_total_students           = User::regularStudents()->count();
        $is_web_designing_students   = User::regularStudents()->where('course_type', 'Web Designing')->count();
        $is_web_development_students = User::regularStudents()->where('course_type', 'Web Development')->count();
        $is_full_stack_development   = User::regularStudents()->where('course_type', 'Full Stack Development')->count();
        $is_php                      = User::regularStudents()->where('course_type', 'Php Development')->count();
        $digital_marketing           = User::regularStudents()->where('course_type', 'Digital Marketing')->count();
        $is_graphic                  = User::regularStudents()->where('course_type', 'Graphic')->count();

        $periodEnrollments = User::regularStudents()
            ->whereBetween('course_joining_date', [$periodStart, $periodEnd])
            ->count();

        [$totalFeesChange, $paidFeesChange, $pendingFeesChange] = $this->getWeekOverWeekChanges();

        $availableYears  = range(2023, (int) date('Y') + 1);
        $availableMonths = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
        ];
        $availableWeeks = $this->getWeeksForYear($selectedYear);

        if ($request->ajax()) {
            return response()->json([
                'year_total_fees'    => $year_total_fees,
                'period_paid_fees'   => $periodPaidFees,
                'payment_online'     => $payment_type_online,
                'payment_cash'       => $payment_type_cash,
                'period_label'       => $periodLabel,
                'period_enrollments' => $periodEnrollments,
                'monthly_fees'       => $monthlyFees,
                'week_chart'         => $weekChartData,
                'month_chart'        => $monthChartData,
                'filter_type'        => $filterType,
            ]);
        }

        return view('admin.dashboard', compact(
            'get_student_list',
            'all_students_total_fees',
            'all_students_paid_fees',
            'periodPaidFees',
            'payment_type_online',
            'payment_type_cash',
            'monthlyFees',
            'enrollmentData',
            'enrollmentYears',
            'weekChartData',
            'monthChartData',
            'is_total_students',
            'is_web_designing_students',
            'is_web_development_students',
            'is_full_stack_development',
            'is_php',
            'is_graphic',
            'digital_marketing',
            'totalFeesChange',
            'paidFeesChange',
            'pendingFeesChange',
            'year_total_fees',
            'filterType',
            'selectedYear',
            'selectedMonth',
            'selectedWeek',
            'periodLabel',
            'periodEnrollments',
            'availableYears',
            'availableMonths',
            'availableWeeks'
        ));
    }

    private function resolvePeriod(string $filterType, int $year, int $month, int $week): array
    {
        if ($filterType === 'year') {
            $start = Carbon::create($year, 1, 1)->startOfDay();
            $end   = Carbon::create($year, 12, 31)->endOfDay();
            return [$start, $end, "Year {$year}"];
        }

        if ($filterType === 'week') {
            $start = Carbon::now()->setISODate($year, $week)->startOfWeek(Carbon::MONDAY);
            $end   = Carbon::now()->setISODate($year, $week)->endOfWeek(Carbon::SUNDAY);
            return [$start, $end, "Week {$week}, {$year} ({$start->format('d M')} – {$end->format('d M Y')})"];
        }

        $start = Carbon::create($year, $month, 1)->startOfMonth();
        $end   = Carbon::create($year, $month, 1)->endOfMonth();
        return [$start, $end, $start->format('F Y')];
    }

    private function getMonthlyFeesForYear(int $year): array
    {
        $fees = [];
        for ($m = 1; $m <= 12; $m++) {
            $fees[] = (int) StudentFees::where('user_status', 'Active')
                ->whereYear('submission_date', $year)
                ->whereMonth('submission_date', $m)
                ->sum('user_fees');
        }
        return $fees;
    }

    private function getEnrollmentData(array $years): array
    {
        $data = [];
        foreach ($years as $year) {
            $monthly = [];
            for ($m = 1; $m <= 12; $m++) {
                $monthly[] = User::regularStudents()
                    ->whereYear('course_joining_date', $year)
                    ->whereMonth('course_joining_date', $m)
                    ->count();
            }
            $data[$year] = $monthly;
        }
        return $data;
    }

    private function getDailyFeesForWeek(int $year, int $week): array
    {
        $start = Carbon::now()->setISODate($year, $week)->startOfWeek(Carbon::MONDAY);
        $days  = [];
        for ($i = 0; $i < 7; $i++) {
            $day   = $start->copy()->addDays($i);
            $days[] = [
                'label'  => $day->format('D'),
                'amount' => (int) StudentFees::where('user_status', 'Active')
                    ->whereDate('submission_date', $day->toDateString())
                    ->sum('user_fees'),
            ];
        }
        return $days;
    }

    private function getDailyFeesForMonth(int $year, int $month): array
    {
        $start = Carbon::create($year, $month, 1)->startOfMonth();
        $daysInMonth = $start->daysInMonth;
        $days = [];
        for ($d = 1; $d <= $daysInMonth; $d++) {
            $day = Carbon::create($year, $month, $d);
            $days[] = [
                'label'  => (string) $d,
                'amount' => (int) StudentFees::where('user_status', 'Active')
                    ->whereDate('submission_date', $day->toDateString())
                    ->sum('user_fees'),
            ];
        }
        return $days;
    }

    private function getWeeksForYear(int $year): array
    {
        $weeks   = [];
        $maxWeek = Carbon::create($year, 12, 28)->weekOfYear;
        for ($w = 1; $w <= $maxWeek; $w++) {
            $start = Carbon::now()->setISODate($year, $w)->startOfWeek(Carbon::MONDAY);
            $end   = Carbon::now()->setISODate($year, $w)->endOfWeek(Carbon::SUNDAY);
            $weeks[$w] = "Week {$w}: {$start->format('d M')} – {$end->format('d M')}";
        }
        return $weeks;
    }

    private function getWeekOverWeekChanges(): array
    {
        $currentWeekStart = Carbon::now()->startOfWeek();
        $currentWeekEnd   = Carbon::now()->endOfWeek();
        $lastWeekStart    = Carbon::now()->subWeek()->startOfWeek();
        $lastWeekEnd      = Carbon::now()->subWeek()->endOfWeek();

        $totalFeesChange = 0;

        $currentWeekPaidFees = StudentFees::where('user_status', 'Active')
            ->whereBetween('submission_date', [$currentWeekStart, $currentWeekEnd])
            ->sum('user_fees');

        $lastWeekPaidFees = StudentFees::where('user_status', 'Active')
            ->whereBetween('submission_date', [$lastWeekStart, $lastWeekEnd])
            ->sum('user_fees');

        $paidFeesChange = 0;
        if ($lastWeekPaidFees > 0) {
            $paidFeesChange = (($currentWeekPaidFees - $lastWeekPaidFees) / $lastWeekPaidFees) * 100;
        }

        $allTotal = User::where('user_status', 'Active')->sum('total_fees');
        $currentWeekPendingFees = $allTotal - $currentWeekPaidFees;
        $lastWeekPendingFees    = $allTotal - $lastWeekPaidFees;

        $pendingFeesChange = 0;
        if ($lastWeekPendingFees > 0) {
            $pendingFeesChange = (($currentWeekPendingFees - $lastWeekPendingFees) / $lastWeekPendingFees) * 100;
        }

        return [$totalFeesChange, $paidFeesChange, $pendingFeesChange];
    }
}
