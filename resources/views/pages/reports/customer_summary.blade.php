@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Customer Report')

@section('content')
<div id="alert">
    @include('components.alert')
</div>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4" id="printableArea">
                <div class="invoice-header">
                    <h2>Darut Tawhid Complex</h2>
                    <h6 class="invoice-date">Address: Kha Para Road, Tongi, Gazipur</h6>
                </div>
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Customer Report</p>
                        <a href="{{ route('customers.index') }}"
                            class="btn btn-secondary btn-md ms-auto no-print">Back</a>
                        <button onclick="printDiv('printableArea')"
                            class="btn btn-primary btn-md no-print">Print</button>
                    </div>
                
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">

                       <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Customer</th>
                                    <th>Phone</th>
                                    <th>Total Will Be Deposited</th>
                                    <th>Current Deposited</th>
                                    <th>Balance</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                        
                            <tbody>
                                @foreach($customers as $customer)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $customer['name'] }}</td>
                                    <td>{{ $customer['phone'] }}</td>
                        
                                    <td>{{ number_format($customer['totalWillBePaid'],2) }}</td>
                        
                                    <td>{{ number_format($customer['currentDeposited'],2) }}</td>
                        
                                    <td>{{ number_format(abs($customer['balance']),2) }}</td>
                        
                                    <td>
                                        @if($customer['status']=='Due')
                                            <span class="text-danger fw-bold">Due</span>
                                        @elseif($customer['status']=='Advance')
                                            <span class="text-success fw-bold">Advance</span>
                                        @else
                                            <span class="text-primary fw-bold">Settled</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                            <tr class="fw-bold bg-light">
                                <td colspan="3" class="text-end">Grand Total</td>
                        
                                <td>{{ number_format($totalWillBeDeposited, 2) }}</td>
                        
                                <td>{{ number_format($totalCurrentDeposited, 2) }}</td>
                        
                                <td>{{ number_format($totalAmount, 2) }}</td>
                        
                                <td></td>
                            </tr>
                        </tfoot>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<style>
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

    @media print {

        .no-print {
            display: none !important;
        }
    }

</style>



<script>
    function printDiv(divId) {
        var printContents = document.getElementById(divId).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }

</script>

