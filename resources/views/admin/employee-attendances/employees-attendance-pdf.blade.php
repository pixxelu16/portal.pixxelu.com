<!DOCTYPE html>
<html>
<head>
    <title>Employees Attendance - {{ $month }} {{ $year }}</title>
    <style>
        body { font-family: 'Arial', sans-serif; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #e0e0e0;
            color: #333;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <!-- Report Title -->
    <h2>Employees Attendance Generated Report On:- {{ now()->format('d M Y') }}</h2>
    <!-- Summary Section -->
    <div class="summary">
        <p><strong>Total Days in {{ $month }}:</strong> {{ $daysInMonth }}</p>
        <p><strong>Total Holidays (Sundays + Alternate Saturdays):</strong> {{ $total_holidays }}</p>
        <p><strong>Total Working Days:</strong> {{ $daysInMonth - $total_holidays }}</p>
        <p><strong>Expected Working Hours:</strong> {{ ($daysInMonth - $total_holidays) * 8 }} hrs</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Present</th>
                <th>Absent</th>
                <th>Leave</th>
                <th>Half Day</th>
                <th>Total Hours</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($employees as $employee)
                <tr>
                    <td>{{ $employee->unique_employee_id }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->employees_attendance_detail->where('attendance_status', 'present')->count() }}</td>
                    <td>{{ $employee->employees_attendance_detail->where('attendance_status', 'absent')->count() }}</td>
                    <td>{{ $employee->employees_attendance_detail->where('attendance_status', 'leave')->count() }}</td>
                    <td>{{ $employee->employees_attendance_detail->where('attendance_status', 'half_day')->count() }}</td>
                    <td>{{ number_format($employee->total_hours, 2) }} hrs</td>

                </tr>
            @empty
                <tr>
                    <td colspan="8">No attendance records available for {{ $month }} {{ $year }}.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
