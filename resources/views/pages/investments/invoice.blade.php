@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Installment Invoice')

@section('content')

<div id="alert">@include('components.alert')</div>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="card-header pb-0">
                        <button class="btn btn-secondary btn-block no-print" onclick="print_receipt('print_area')">
                            🖨️ Print Invoice
                        </button>
                    </div>

                    <div class="invoice-box print_area">
                        <div class="invoice-header">
                            <h2 style="color: green;">Darut Tawhid Complex</h2>
                            <h6 class="invoice-date" style="color: #800000;">Address: Kha Para Road, Tongi, Gazipur</h6>
                            <h4 style="color: blue;">ব্যবস্থাপনায়: দারুত তাওহীদ প্রপার্টিজ </h4>
                        </div>

                        <div class="invoice-title">
                            <h1>INSTALLMENT INVOICE</h1>
                            <h6>Invoice No: {{ $investment->invoice_no ?? 'N/A' }}</h6>
                            <h6>Date:
                                {{ $investment->date ? \Carbon\Carbon::parse($investment->date)->format('d-m-Y') : 'N/A' }}
                            </h6>
                        </div>

                        <div class="invoice-details">
                            <div class="row">
                                <div class="label">Project:</div>
                                <div class="value">{{ $investment->project->name ?? 'N/A' }}</div>
                            </div>
                            <div class="row">
                                <div class="label">Customer:</div>
                                <div class="value">{{ $investment->customer->name ?? 'N/A' }}</div>
                            </div>
                            <div class="row">
                                <div class="label">Phone:</div>
                                <div class="value">{{ $investment->customer->phone ?? 'N/A' }}</div>
                            </div>
                            <div class="row">
                                <div class="label">Purpose:</div>
                                <div class="value">{{ $investment->purpose ?? '-' }}</div>
                            </div>
                            <div class="row">
                                <div class="label">Flat Quantity:</div>
                                <div class="value">{{ $investment->customer->flat_quantity ?? 'N/A' }}</div>
                            </div>
                            <div class="row">
                                <div class="label">Payment Mathod/Check No:</div>
                                <div class="value">{{ $investment->check_no ?? '-' }}</div>
                            </div>
                            <div class="row">
                                <div class="label">Investment Amount:</div>
                                <div class="value">৳ {{ number_format($investment->amount, 2) }}</div>
                            </div>
                            <div class="row">
                                <div class="label">Amount (in words):</div>
                                <div class="value">{{ $amountInWords }}</div>
                            </div>
                        </div>

                        <div class="invoice-footer mt-5">
                            <table style="width: 100%; margin-top: 60px; text-align: center;">
                                <tr>
                                    <td>
                                        _________________<br>
                                        Finance Secretary
                                    </td>
                                    <td>
                                        _________________<br>
                                        General Secretary
                                    </td>
                                    <td>
                                        ________<br>
                                        Chairman
                                    </td>
                                    <td>
                                        ____________<br>
                                        Received By
                                    </td>
                                    <td>
                                        ________________<br>
                                        Accounts Manager
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
        box-shadow: none;
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
    }

    .invoice-header h2 {
        margin: 0;
        font-weight: bold;
        text-align: center;
        /* font-size: 24px; */
    }

    .invoice-header h4 {
        margin: 0;
        font-weight: bold;
        text-align: center;

    }

    .invoice-date {
        text-align: center;
        font-size: 14px;
    }

    .invoice-title {
        text-align: center;
        margin: 30px 0;
    }

    .invoice-title h1 {
        font-size: 28px;
        margin-bottom: 10px;
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

    .invoice-footer table {
        width: 100%;
        margin-top: 60px;
    }

    .invoice-footer td {
        padding: 20px 2px;
        font-size: 14px;
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
            box-shadow: none !important;
        }
    }

</style>


@endsection

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
                        padding: 0;
                    }

                    .print_area {
                        margin: 0 auto;
                        padding: 40px 50px;
                        max-width: 1000px;
                        font-family: 'Arial', sans-serif;
                        background: white;
                        color: #000;
                        border: 1px solid #000;
                    }

                    @media print {
                        body * {
                            visibility: hidden;
                        }
                        .print_area, .print_area * {
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
            </head>
            <body onload="window.print(); window.close();">
                ${printContents}
            </body>
            </html>
        `);
        printWindow.document.close();
    }

</script>
