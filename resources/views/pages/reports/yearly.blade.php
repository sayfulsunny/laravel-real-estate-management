@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Yearly Report')

@section('content')
<div class="container-fluid py-4">

    {{-- Report Card --}}
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="card-header pb-0 d-flex">
                        {{-- Date Filter Form --}}
                        <div class="row mb-4">
                            <div class="col-12">
                                <form action="{{ route('yearly.report') }}" method="GET"
                                    class="d-flex align-items-center gap-3 flex-wrap">
                                    <div class="form-group">
                                        <label for="start_date">From Date</label>
                                        <input type="date" id="start_date" name="start_date"
                                            value="{{ request('start_date') }}" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="end_date">To Date</label>
                                        <input type="date" id="end_date" name="end_date"
                                            value="{{ request('end_date') }}" class="form-control">
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-4">Filter</button>
                                    <button class="btn btn-secondary no-print" onclick="print_report('print_area')">
                                        🖨️ Print Report
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>

                    <div class="print_area">
                        <div class="invoice-box">
                            <div class="invoice-header">
                                <h2 style="color: green;">Darut Tawhid Complex</h2>
                                <h6 style="color: #800000;">Kha Para Road, Tongi, Gazipur</h6>
                                <h5 style="color: blue;">ব্যবস্থাপনায়: দারুত তাওহীদ প্রপার্টিজ</h5>
                                @if(request('start_date') && request('end_date'))
                                <h6>Statement of Financial Accounts for the period from:
                                    {{ \Carbon\Carbon::parse(request('start_date'))->format('d-m-Y') }} to
                                    {{ \Carbon\Carbon::parse(request('end_date'))->format('d-m-Y') }}</h6>
                                @else
                                <h4>Yearly Report: {{ $year ?? now()->year }}</h4>
                                @endif

                            </div>

                            <div class="invoice-details">
                                <div class="row">
                                    <div class="label">Opening Balance Cash in hand:</div>
                                    <div class="value">৳ {{ number_format($openingBalance, 2) }}</div>
                                </div>
                                <div class="row">
                                    <div class="label">Total Received From Share Holder/Flat Holder:</div>
                                    <div class="value">৳ {{ number_format($totalReceived, 2) }}</div>
                                </div>
                                <div class="row">
                                    <div class="label">Total Received From Others _____________ :</div>
                                    <div class="value">৳ {{ number_format($othersReceived, 2) }}</div>
                                </div>
                                <div class="row">
                                    <div class="label">Total _____________ :</div>
                                    <div class="value">৳ {{ number_format($totalReceivable, 2) }}</div>
                                </div>
                                <div class="row">
                                    <div class="label">Total Expense:</div>
                                    <div class="value"> - ৳ {{ number_format($totalExpense, 2) }}</div>
                                </div>
                                <div class="row">
                                    <div class="label"><strong>Closing Balance Cash in Hand:</strong></div>
                                    <div class="value"><strong>৳ {{ number_format($closingBalance, 2) }}</strong></div>
                                </div>
                            </div>

                            <div class="invoice-footer mt-5">
                                <table class="signature-table">
                                    <tr>
                                        <td>____________________<br><strong>Manager Accounts</strong></td>
                                        <td>____________________<br><strong>Finance Secretary</strong></td>
                                        <td>____________________<br><strong>General Secretary</strong></td>
                                        <td>____________________<br><strong>Chairman</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


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

    .invoice-header h2,
    .invoice-header h4,
    .invoice-header h5 {
        margin: 0;
    }

    .invoice-details .row {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px dashed #999;
    }

    .invoice-details .label {
        font-weight: bold;
        width: 60%;
        color: #000;
    }

    .invoice-details .value {
        width: 40%;
        text-align: right;
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
    }

</style>

<script>
    function print_report(className) {
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
                body { margin: 0; padding: 40px 50px; font-family: 'Arial', sans-serif; color: #000; }
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
@endsection
