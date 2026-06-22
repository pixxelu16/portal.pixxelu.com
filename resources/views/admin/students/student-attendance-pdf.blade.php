<!DOCTYPE html>
<html>
    <head>
        <style>
            body {
                font-family: sans-serif;
                font-size: 10px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid #000;
                padding: 3px 2px;
                text-align: center;
                font-size: 10px;
            }
            th {
                background: #f0f0f0;
            }
        </style>
    </head>
    <body>
        <h3 style="text-align:center; margin-bottom:10px;">
            {{ $attendanceTitle }} - {{ $date->format('F, Y') }}
        </h3>
        <table>
            <tr>
                <th>Sr.No.</th>
                <th>Registration</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Course</th>
                <th>Duration</th>
                <th>Joining</th>
                @for($i=1; $i <= $days; $i++)
                    <th>{{ str_pad($i,2,'0',STR_PAD_LEFT) }}-{{ $date->day($i)->format('D') }}</th>
                @endfor
            </tr>
            @php $n=1; @endphp
            @foreach($students as $stu)
            <tr>
                <td>{{ $n++ }}.</td>
                <td>{{ $stu->id ??'-' }}</td>
                <td>{{ $stu->name ??'-' }}</td>
                <td>{{ substr($stu->student_phone_no, 0, 5) . '-' . substr($stu->student_phone_no, 5) ??'-' }}</td>
                <td>{{ $stu->course_type ??'-' }}</td>
                <td>{{ $stu->course_duration ??'-' }}</td>
                <td>{{ \Carbon\Carbon::parse($stu->course_joining_date)->format('d M Y') ??'-' }}</td>
                @for($i=1; $i <= $days; $i++)
                <td></td>
                @endfor
            </tr>
            @endforeach
        </table>
    </body>
</html>