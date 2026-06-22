<!--DataTables CSS-->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
    table th, table td {
        padding: 12px 10px;
    }
    table tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }
    table tbody tr:hover {
        background-color: #e9ecef;
    }
    td.dataTables_empty {
        color: red;
        font-size: 14px;
    }
    @media print {
        h2 span {
            display: none !important;
        }
    }
    .header-buttons .btn {
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 6px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }
    .header-buttons .btn-back {
        background-color: #f8f9fa;
        color: #495057;
        border: 1px solid #ced4da;
        margin-right: 10px;
    }
    .header-buttons .btn-back:hover {
        background-color: #e2e6ea;
        color: #212529;
        border-color: #adb5bd;
    }
    .header-buttons .btn-print {
        background-color: #007bff;
        color: #fff;
        border: 1px solid #007bff;
    }
    .header-buttons .btn-print:hover {
        background-color: #0069d9;
        border-color: #0062cc;
        color: #fff;
    }
    .header-buttons .btn i {
        margin-right: 6px;
    }
    @media print {
        table tr.total-row {
            background-color: #343a40 !important;
            color: white !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            font-size: 1.05rem;
        }
        table tr.total-row td {
            border: 1px solid #000 !important;
            font-weight: 700 !important;
        }
    }
    tr.total-row {
        font-weight: 900;
        font-size: 18px;
        letter-spacing: 0.5px;
    }
    @media print {
    .header-buttons,
    .dataTables_filter,
    .dataTables_length,
    .dataTables_info,
        .dataTables_paginate {
            display: none !important;
        }
        tr.total-row {
            background-color: #343a40 !important;
            color: white !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
    }
    @media print {
        @page {
            margin: 0;
        }
        body {
            margin: 1cm;
        }
    }
</style>
<div class="container my-5" style="position: relative;">
    <!--Header--> 
    <h2 style="text-align: center; font-weight: 700; letter-spacing: 1px; font-size: 1.8rem; color: #343a40; position: relative;">
        Monthly Paid Students Fees List: {{ $currentMonth }} {{ $currentYear }}
        <span class="header-buttons" style="position: absolute; right: 0; top: 50%; transform: translateY(-50%);">
            <a href="{{ url()->previous() }}" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <button onclick="window.print()" class="btn btn-print">
                <i class="fas fa-print"></i> Print Report
            </button>
        </span>
    </h2>
    <div class="table-responsive mt-4">
        <table class="table table-bordered table-striped" id="feesTable" style="border-collapse: collapse;">
            <thead class="thead-dark">
                <tr>
                    <th>Sr No.</th>
                    <th class="text-center">Registration ID</th>
                    <th>Name</th>
                    <th>Phone No</th>
                    <th class="text-right">Fee Amount</th>
                    <th>Fee Payment Type</th>
                    <th class="text-right">Remaining Fee</th>
                    <th>Fee Submission Date</th>
                    <th class="text-right">Monthly Fee</th>
                    <th class="text-center">Fee Status</th>
                </tr>
            </thead>
            <tbody>
                @php $count = 1; @endphp
                @foreach($reportData as $data)
                <tr style="vertical-align: middle;">
                    <td>{{ $count++ }}.</td>
                    <td class="text-center">{{ $data['id'] }}</td>
                    <td>{{ $data['name'] }}</td>
                    <td>{{ $data['phone'] }}</td>
                    <td class="text-right">{{ $data['formattedFees'] }}</td>
                    <td>{{ $data['paymentTypes'] }}</td>
                    <td class="text-right">{{ number_format($data['remainingFees']) }}</td>
                    <td>{{ $data['lastSubmissionDate'] }}</td>
                    <td class="text-right">{{ number_format($data['monthlyFee']) }}</td>
                    <td class="text-center">
                        <span style="color: #2bc750ff; font-weight: 600;">{{ $data['status'] }}</span>
                    </td>
                </tr>
                @endforeach
                <tfoot>
                    <tr class="total-row">
                        <td colspan="4" class="text-center">Total</td>
                        <td class="text-right">{{ number_format($totalPaidCurrentMonth) }}</td>
                        <td></td>
                        <td class="text-right">{{ number_format($totalRemainingFees) }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
            </tbody>
        </table>
    </div>
</div>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    let table;
    $(document).ready(function() {
        table = $('#feesTable').DataTable({
            "pageLength": 10,
            "ordering": true
        });
    });
    function cleanPrint() {
        table.destroy();
        window.print();
        setTimeout(() => {
            table = $('#feesTable').DataTable({
                "pageLength": 10,
                "ordering": true
            });
        }, 500);
    }
</script>
<script>
    window.onload = function () {
        window.print();
    };
</script>