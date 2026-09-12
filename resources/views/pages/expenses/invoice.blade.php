@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Expense Voucher')

@section('content')
<div id="alert">@include('components.alert')</div>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="card-header pb-0 d-flex justify-content-end">
                        <button class="btn btn-secondary no-print" onclick="print_receipt('print_area')">
                            🖨️ Print Voucher
                        </button>
                    </div>

                    <div class="invoice-box print_area">
                        <div class="invoice-header">
                            <h2 style="color: green;">Darut Tawhid Complex</h2>
                            <h6 class="invoice-date" style="color: #800000;">Kha Para Road, Tongi, Gazipur</h6>
                            <h5 style="color: blue;">ব্যবস্থাপনায়: দারুত তাওহীদ প্রপার্টিজ </h5>
                        </div>

                        <div class="invoice-title">
                            <h1>Expense Voucher</h1>
                            <h6>Voucher No: {{ $expense->id }}</h6>
                            <h6>Date: {{ \Carbon\Carbon::parse($expense->date)->format('d-m-Y') }}</h6>
                        </div>

                        <div class="section-header">Expense Details</div>
                        <div class="invoice-details">
                            <div class="row">
                                <div class="label">Project:</div>
                                <div class="value">{{ $expense->project->name ?? 'N/A' }}</div>
                            </div>
                            <div class="row">
                                <div class="label">Category:</div>
                                <div class="value">{{ $expense->expenseCategory->name ?? 'N/A' }}</div>
                            </div>
                            <div class="row">
                                <div class="label">Expense Name:</div>
                                <div class="value">{{ $expense->expense_name }}</div>
                            </div>
                            <div class="row">
                                <div class="label">Amount:</div>
                                <div class="value">৳ {{ number_format($expense->amount, 2) }}</div>
                            </div>
                            <div class="row">
                                <div class="label">Amount (in words):</div>
                                <div class="value">{{ $amountInWords }}</div>
                            </div>
                            <div class="row">
                                <div class="label">Check No:</div>
                                <div class="value">{{ $expense->check_no ?? 'N/A' }}</div>
                            </div>
                            <div class="row">
                                <div class="label">Voucher No:</div>
                                <div class="value">{{ $expense->voucher_no ?? 'N/A' }}</div>
                            </div>
                            <div class="row">
                                <div class="label">Discription:</div>
                                <div class="value">{{ $expense->description ?? 'N/A' }}</div>
                            </div>
                            <div class="row">
                                <div class="label">Status:</div>
                                <div class="value">
                                    <span class="badge bg-{{ $expense->is_approved ? 'success' : 'warning' }}">
                                        {{ $expense->is_approved ? 'Approved' : 'Pending' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="invoice-footer mt-5">
                            <table class="signature-table">
                                <tr>
                                    <td>____________________<br><strong>Finance Secretary</strong></td>
                                    <td>____________________<br><strong>General Secretary</strong></td>
                                    <td>____________________<br><strong>Chairman</strong></td>
                                    <td>____________________<br><strong>Prepared By</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="padding-top:50px; text-align:center;">
                                        ______________________<br>
                                        <strong>Received By</strong>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- Styles --}}
<style>
    .invoice-box {
        max-width: 800px;
        margin: 0 auto;
        background: #fff;
        padding: 40px 50px;
        border: 1px solid #000;
        font-size: 16px;
        line-height: 24px;
        color: #000;
        font-family: 'Arial', sans-serif;
        position: relative;
        z-index: 1;
        overflow: hidden;
    }

    .invoice-box::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('/assets/img/darut-bg.jpeg');
        background-size: cover;
        background-position: center;
        opacity: 0.2;
        z-index: 0;
    }

    .invoice-box>* {
        position: relative;
        z-index: 1;
    }

    .invoice-header {
        border-bottom: 2px solid #000;
        padding-bottom: 10px;
        margin-bottom: 20px;
        text-align: center;
    }

    .invoice-header h2 {
        margin: 0;
        /* font-size: 24px; */
        font-weight: bold;
    }

    .invoice-header h4 {
        margin: 0;
        font-weight: bold;
        text-align: center;
    }

    .invoice-date {
        font-size: 14px;
        color: #555;
    }

    .invoice-title {
        text-align: center;
        margin: 30px 0;
    }

    .invoice-title h1 {
        font-size: 28px;
        margin-bottom: 10px;
    }

    .section-header {
        font-weight: bold;
        font-size: 16px;
        margin: 30px 0 10px;
        text-decoration: underline;
    }

    .invoice-details .row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px dashed #999;
    }

    .invoice-details .label {
        font-weight: bold;
        width: 40%;
        color: #000;
    }

    .invoice-details .value {
        width: 60%;
        text-align: right;
    }

    .badge {
        padding: 4px 10px;
        border-radius: 5px;
        font-size: 14px;
    }

    .bg-success {
        background-color: #28a745;
        color: #fff;
    }

    .bg-warning {
        background-color: #ffc107;
        color: #000;
    }

    .signature-table {
        width: 100%;
        margin-top: 60px;
        text-align: center;
    }

    .signature-table td {
        padding: 20px 10px;
        font-size: 14px;
        vertical-align: bottom;
    }

    .footer-note {
        text-align: center;
        margin-top: 30px;
        font-size: 13px;
        color: #555;
        font-style: italic;
    }

    .no-print {
        margin: 10px 20px 0 0;
    }

    @media print {
        .no-print {
            display: none !important;
        }

        body * {
            visibility: hidden;
        }

        .print_area,
        .print_area * {
            visibility: visible;
        }

        .print_area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }

        .invoice-box {
            border: none !important;
        }
    }

</style>
@endsection

{{-- Print Script --}}
<script>
    function print_receipt(className) {
        const printContents = document.querySelector('.' + className).outerHTML;
        const originalTitle = document.title;

        const styles = [...document.querySelectorAll('link[rel="stylesheet"], style')]
            .map(style => style.outerHTML)
            .join('\n');

        const printWindow = window.open('', '_blank', 'height=800,width=1000');
        printWindow.document.write(`
            <html>
            <head>
                <title>${originalTitle}</title>
                ${styles}
                <style>
                    body {
                        margin: 0;
                        padding: 40px 50px;
                        font-family: 'Arial', sans-serif;
                        background: white;
                        color: #000;
                    }
                </style>
            </head>
            <body onload="window.print(); window.close();">
                ${printContents}
            </body>
            </html>
        `);
        printWindow.document.close();
    }

</script>
