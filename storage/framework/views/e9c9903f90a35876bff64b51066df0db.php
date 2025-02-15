<!DOCTYPE html>
<html>
<head>
    <title>Employee Attendance - <?php echo e($month); ?> <?php echo e($year); ?></title>
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
    <h2>Employee Attendance Generated Report - <?php echo e(now()->format('d F Y')); ?>

    </h2>  



    <!-- Summary Section -->
    <div class="summary">
        <p><strong>Total Days in <?php echo e($month); ?>:</strong> <?php echo e($daysInMonth); ?></p>
        <p><strong>Total Holidays (Sundays + Alternate Saturdays):</strong> <?php echo e($total_holidays); ?></p>
        <p><strong>Total Working Days:</strong> <?php echo e($daysInMonth - $total_holidays); ?></p>
        <p><strong>Expected Working Hours:</strong> <?php echo e(($daysInMonth - $total_holidays) * 8); ?> hrs</p>
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

                <tr>
                    <td><?php echo e($employee->unique_employee_id); ?></td>
                    <td><?php echo e($employee->name); ?></td>
                    <td><?php echo e($employee->employees_attendance_detail->where('attendance_status', 'present')->count()); ?></td>
                    <td><?php echo e($employee->employees_attendance_detail->where('attendance_status', 'absent')->count()); ?></td>
                    <td><?php echo e($employee->employees_attendance_detail->where('attendance_status', 'leave')->count()); ?></td>
                    <td><?php echo e($employee->employees_attendance_detail->where('attendance_status', 'half_day')->count()); ?></td>
                    <td><?php echo e(number_format($employee->total_hours, 2)); ?> hrs</td>

                </tr>
           

        </tbody>
    </table>


</body>
</html>
<?php /**PATH C:\xampp\htdocs\pixxelu-student-portal-new\resources\views/admin/employee-attendances/search-employee-attendance-pdf.blade.php ENDPATH**/ ?>