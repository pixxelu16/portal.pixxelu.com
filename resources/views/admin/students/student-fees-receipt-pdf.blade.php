<!DOCTYPE html>
<html>
<head>
    <title>Fee Receipt</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 5px;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 5px;
            font-size: 12px;
            overflow: hidden;
        }
        .receipt-container {
            border: 2px solid #000;
            padding: 5px;
            width: 100%;
            max-width: 700px;
            margin: auto;
            text-align: center;
            background: white;
            box-sizing: border-box;
        }
        .header {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .details {
            margin-top: 5px;
            text-align: left;
            font-size: 12px;
        }
        .footer {
            margin-top: 10px;
            font-size: 10px;
            text-align: center;
            font-weight: bold;
            border-top: 1px solid #000;
            padding-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            font-size: 10px;
        }
        th, td {
            border: 1px solid black;
            padding: 4px;
            text-align: left;
        }
        .total-row {
            font-weight: bold;
            background-color: #f0f0f0;
        }
        .signature {
            margin-top: 15px;
            text-align: right;
            font-weight: bold;
            font-size: 12px;
        }
        .logo {
            position: absolute;
            top: 96px;
            right: 50px;
        }
        .logo img {
            width: 80px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #000;
        }
        table, tr, td, th {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="header">Fee Receipt Generated On</div>
        <p><strong>{{ \Carbon\Carbon::now()->format('d M Y') }}</strong></p>
        <div class="details">
            <p><strong>Name:</strong> {{ $student->name }}</p>
            <p><strong>Father Name:</strong> {{ $student->father_name }}</p>
            <p><strong>Course:</strong> {{ $student->course_type }}</p>
            <p><strong>Duration:</strong> {{ $student->course_duration }}</p>
            <p><strong>Phone:</strong> {{ substr($student->student_phone_no, 0, 5) . '-' . substr($student->student_phone_no, 5) }}</p>
            <p><strong>Joining Date:</strong> {{ \Carbon\Carbon::parse($student->course_joining_date)->format('d M Y') }}</p>
        </div>
        <div class="logo">
            <img src="{{ public_path('uploads/users/'. $student->user_pic) }}" alt="Photo">
        </div>
        <h3>Summary</h3>
        <table>
            <tr><th>Total Fees</th><td>Rs {{ number_format($totalFees) }}</td></tr>
            <tr><th style="color:green">Paid Fees</th><td>Rs {{ number_format($totalFeesPaid) }}</td></tr>
            <tr><th style="color:red">Remaining Fees</th><td>Rs {{ number_format($remainingFees) }}</td></tr>
            <tr><th>Last Paid Fees</th><td>Rs {{ number_format($lastPaidAmount) }}</td></tr>
            <tr><th>Last Paid Month</th><td>{{ \Carbon\Carbon::parse($lastPaidMonth)->format('M Y') }}</td></tr>
        </table>
        <h3>Monthly Payments</h3>
        <table>
            <tr>
                <th>Month</th>
                <th>Paid Amount</th>
                <th>Payment Date</th>
                <th>Type</th>
            </tr>
            @php
                $totalMonthlyPaid = 0;
                $start = \Carbon\Carbon::parse($student->course_joining_date)->startOfMonth();
                $end = \Carbon\Carbon::now()->endOfMonth();
                $months = [];
                while ($start <= $end) {
                    $months[$start->format('Y-m')] = ['month' => $start->format('F Y'), 'payments' => []];
                    $start->addMonth();
                }
                foreach ($monthlyFees as $fee) {
                    $monthKey = \Carbon\Carbon::parse($fee->submission_date)->format('Y-m');
                    if (isset($months[$monthKey])) {
                        $months[$monthKey]['payments'][] = [
                            'paid' => $fee->user_fees,
                            'date' => \Carbon\Carbon::parse($fee->submission_date)->format('d M Y'),
                            'type' => ucfirst($fee->payment_type ?? '-')
                        ];
                        $totalMonthlyPaid += $fee->user_fees;
                    }
                }
            @endphp
            @foreach ($months as $month)
                @if (count($month['payments']) > 0)
                    @foreach ($month['payments'] as $index => $payment)
                        <tr>
                            <td>{{ $index === 0 ? $month['month'] : '' }}</td>
                            <td>Rs {{ number_format($payment['paid']) }}</td>
                            <td>{{ $payment['date'] }}</td>
                            <td>{{ $payment['type'] }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>{{ $month['month'] }}</td>
                        <td>Not Paid</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                @endif
            @endforeach
            <tr class="total-row">
                <td><strong style="color:green">Total Paid</strong></td>
                <td><strong>Rs {{ number_format($totalMonthlyPaid) }}</strong></td>
                <td colspan="2"></td>
            </tr>
        </table>
        <div class="signature">
            <p>Authorized Manager Signature</p>
            <p>__________________________</p>
        </div>
        <div class="footer">
            <p>Thank you for your payment.</p>
            <p>For any inquiries, contact our office.</p>
        </div>
    </div>
</body>
</html>
