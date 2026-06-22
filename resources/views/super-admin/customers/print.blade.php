<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Job Letter</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            color: #333;
            padding: 40px;
            font-size: 14px;
        }
        .top-date {
            text-align: right;
            font-size: 13px;
            margin-bottom: 10px;
        }
        .header {
            text-align: center;
        }
        .header .logo {
            width: 40px;
            margin-bottom: 10px;
        }
        td {
            color: #080808f5;
            font-weight: 700;
            font-size: 12px;
        }
        .job-title {
            font-size: 20px;
            font-weight: bold;
            color: #2b4eff;
            margin-top: 10px;
        }
        .section-divider {
            font-size: 13px;
            line-height: 1.6;
            margin-top: 30px;
            border-top: 1px dashed #ccc;
            padding-top: 20px;
        }        
        .info-section {
            display: flex;
            gap: 20px;
        }
        .left-img {
            flex: 0 0 160px;
            text-align: center;
        }
        .left-img img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid #c7c1c100;
        }
        .left-img small {
            font-size: 12px;
            display: block;
            margin-top: 30px;
            color: gree;
            color: #4c5fc1;
        }
        .dynamic-td {
            color: #080808f5;
            font-weight: 700;
            font-size: 12px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 6px 10px;
        }
        .label {
            font-weight: 500;
            color: #4c5fc1;
        }
        .icon {
            color: #aaa;
            margin-left: 5px;
        }
        .qr-section {
            display: flex;
            justify-content: center;
            gap: 40px;
            margin: 30px 0 20px;
        }
        .qr-section img {
            width: 90px;
            height: 90px;
        }
        .qr-label {
            text-align: center;
            font-size: 11px;
            margin-top: 5px;
            color: #666;
        }
        .three-column {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .column {
            flex: 1;
            padding: 0 10px;
        }
        .column .label {
            font-weight: 500;
            color: #2b4eff;
        }
        .column .value {
            border-bottom: 1px solid #888;
            padding: 3px 0;
            font-weight: 500;
            color: #222;
        }
        .rules {
            font-size: 13px;
            line-height: 1.6;
            margin-top: 30px;
            border-top: 1px dashed #ccc;
            padding-top: 20px;
        }
        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            font-size: 14px;
        }
        </style>
    </head>
    <body>
        <!--header logo & title-->
        <div class="header">
            <img src="{{ url('public/uploads/customers/download (1).png') }}" alt="Logo" class="logo"><br>
            <strong>pixxelu</strong><br> 
            <strong>*YOUR EMPLOYEE SOFTWARE*</strong><br>
            <small>+918219373976 | www.pixxelu.com | info@kapoor.com*</small><br>
            <div class="job-title">Job Letter</div>
        </div>
        <!--border-->
        <div class="section-divider"></div>
        <!--Info section-->
        <div class="info-section">
            <div class="left-img">
                @if($employee_detail->user_pic)
                    <img src="{{ url('public/uploads/employees/' .$employee_detail->user_pic) }}" alt="Profile Image">
                @else
                    <img src="{{ url('public/uploads/employees/default_user.png') }}" alt="Profile Image">
                @endif
                <small>
                Home Address <i class="bi bi-arrow-return-right"></i>
                <span class="dynamic-td">{{ $employee_detail->address ?? 'Chamba' }}</span>
                </small>
            </div>
            <div>
                <table class="info-table">
                    <tr>
                        <td class="label">Serial No <i class="bi bi-arrow-return-right icon"></i></td>
                        <td>{{ $employee_detail->unique_employee_id ??'12345'}}</td>
                        <td class="label">National ID <i class="bi bi-arrow-return-right icon"></i></td>
                        <td>{{ $employee_detail->national_id ??'98765'}}</td>
                        <td class="label">Date of Joining <i class="bi bi-arrow-return-right icon"></i></td>
                        <td>{{ \Carbon\Carbon::parse($employee_detail->joining_date)->format('d F, Y') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Registration/ID <i class="bi bi-arrow-return-right icon"></i></td>
                        <td>{{ $employee_detail->unique_employee_id ??'12345' }}</td>
                        <td class="label">Employee Role <i class="bi bi-arrow-return-right icon"></i></td>
                        <td>{{ $employee_detail->employee_role ?? 'Developer' }}</td>
                        <td class="label">Username <i class="bi bi-arrow-return-right icon"></i></td>
                        <td>{{ $employee_detail->name ??'56565'}}</td>
                    </tr>
                    <tr>
                        <td class="label">Name Of Employee<i class="bi bi-arrow-return-right icon"></i></td>
                        <td>{{ $employee_detail->name ??'56565'}}</td>
                        <td class="label">Father/Husband Name <i class="bi bi-arrow-return-right icon"></i></td>
                        <td>{{ $employee_detail->father_name ??'56565'}}</td>
                        <td class="label">Monthly Salary <i class="bi bi-arrow-return-right icon"></i></td>
                        <td>{{ $employee_detail->net_salary ??'5000'}}</td>
                    </tr>
                    <tr>
                        <td class="label">Password <i class="bi bi-arrow-return-right icon"></i></td>
                        <td>$2y$10$.ekZVAZQO</td>
                    </tr>
                </table>
            </div>
        </div>
        <!--qr code section-->
        <div class="qr-section">
            <div>
                <img src="{{ url('public/uploads/customers/download.png') }}" alt="Web Portal QR">
                <div class="qr-label">Web Portal</div>
            </div>
            <div>
                <img src="{{ url('public/uploads/customers/download.png') }}" alt="Android QR">
                <div class="qr-label">Android App</div>
            </div>
            <div>
                <img src="{{ url('public/uploads/customers/download.png') }}" alt="iOS QR">
                <div class="qr-label">iOS App</div>
            </div>
        </div>
        <!--bottom divider-->
        <div class="section-divider"></div>
        <div>
            <table class="info-table">
                <tr>
                    <td class="label">Date of Birth <i class="bi bi-arrow-return-right icon"></i></td>
                    <td>{{ \Carbon\Carbon::parse($employee_detail->dob)->format('d M, Y') }}</td>
                    <td class="label">Blood Group <i class="bi bi-arrow-return-right icon"></i></td>
                    <td>{{ $employee_detail->blood ?? 'B+' }}</td>
                    <td class="label">Education<i class="bi bi-arrow-return-right icon"></i></td>
                    <td>{{ $employee_detail->qualification ?? 'BCA' }}</td>
                </tr>
                <tr>
                    <td class="label">Gender<i class="bi bi-arrow-return-right icon"></i></td>
                    <td>{{ $employee_detail->gender ?? 'Male' }}</td>
                    <td class="label">Experience <i class="bi bi-arrow-return-right icon"></i></td>
                    <td>{{ $employee_detail->experince ?? '2 Year' }}</td>
                    <td class="label">Mobile No<i class="bi bi-arrow-return-right icon"></i></td>
                    <td>{{ $employee_detail->employee_phone_no ?? '82193-73976' }}</td>
                </tr>
                <tr>
                    <td class="label">Religion <i class="bi bi-arrow-return-right icon"></i></td>
                    <td>{{ $employee_detail->religion ?? 'Hindu' }}</td>
                    <td></td>
                    <td></td>
                    <td class="label">Email Address<i class="bi bi-arrow-return-right icon"></i></td>
                    <td>{{ $employee_detail->email ?? 'kapoorthakur906@gmail.com' }}</td>
                </tr>
            </table>
        </div>
        <!--rules section-->
        <div class="rules">
            <strong>Rules And Regulations:</strong><br><br>
            Our company policies define the standards of behavior, dress, and work ethics expected from every team member.<br>

            Employees are expected:<br>

            To be regular and punctual at work<br>

            To respect all colleagues and clients equally<br>

            To maintain professionalism and proper conduct<br>

            To care for company property and resources<br>

            To follow instructions and complete tasks responsibly<br>

            To keep the workspace clean and organized<br>

            To follow the company dress code<br>

            To stay updated with all official communications<br>
        </div>
        <!--signature section-->
        <div class="signature-section">
            <div>Signature of Authority ______________________</div>
            <div>Institute Stamp ______________________</div>
        </div>
        <!--print on load-->
        <script>
            window.onload = function () {
                window.print();
            };
        </script>
    </body>
</html>