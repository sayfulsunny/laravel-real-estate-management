@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Installment Report')

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
                        <p class="mb-0">Installment Report for {{ $customer->name }}</p>
                        <a href="{{ route('customers.index') }}"
                            class="btn btn-secondary btn-md ms-auto no-print">Back</a>
                        <button onclick="printDiv('printableArea')"
                            class="btn btn-primary btn-md no-print">Print</button>
                    </div>
                    <p class="mb-0">Phone:{{ $customer->phone }}</p>
                    <p class="mb-0">Address:{{ $customer->address }}</p>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">

                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Installment Date
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Project Name
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Purpose
                                    </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Amount
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($investments as $inv)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($inv['date'])->format('F d, Y') }}</td>
                                    <td>{{ $inv['project'] }}</td>
                                    <td>{{ $inv['purpose'] }}</td>
                                    <td>{{ number_format($inv['amount'], 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="text-end mt-3 pe-4">
                            <strong>Total Paid Amount: {{ number_format($totalAmount, 2) }}</strong>
                        </div>

                        <div class="row mt-3 px-4">
                            <div class="col-md-4">
                                <p><strong>Total will be deposited amount up to  {{ \Carbon\Carbon::now()->format('F Y') }}:</strong>
                                  {{ number_format($totalWillBePaid, 2) }}
                                </p>

                                <p><strong>Total current deposited amount:</strong>
                                   {{ number_format($totalAmount,2) }}
                                </p>

                                <p><strong>Balance:</strong>
                                   {{ number_format($balance, 2) }}
                                </p>
                               <p>Status: 
                                    @if($balance > 0)
                                        <span style="color: red; font-weight: bold;">Due</span>
                                    @elseif($balance < 0)
                                        <span style="color: green; font-weight: bold;">Advance</span>
                                    @else
                                        <span style="color: blue; font-weight: bold;">Settled</span>
                                    @endif
                                </p>
                               
                            </div>
                        </div>

                        
                        <!-- Auto Installment Toggle -->
                        {{--<div class="row mt-3 px-4 no-print">
                            <div class="col-md-4">
                                <form action="{{ route('installment.toggleAuto', $customer->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-{{ $autoStatus === 'on' ? 'danger' : 'success' }}">
                                        {{ $autoStatus === 'on' ? 'Stop Auto Installment' : 'Start Auto Installment' }}
                                    </button>
                                </form>
                            </div>
                        </div>--}}

                        <!-- Manual Payment Form -->
                        <form class="no-print" action="{{ route('installment.installment') }}" method="POST">
                            @csrf
                            <div class="row mt-4 px-4">
                                <div class="col-md-4">
                                    <label>Enter Auto Installment Amount</label>
                                    <input type="number" name="auto_installment_amount" id="addAmount"
                                        class="form-control" required>
                                </div>

                                <input type="hidden" name="customer_id" value="{{ $customer->id }}">

                                <div class="col-md-4 mt-4">
                                    <button type="submit" class="btn btn-success">Save Payment</button>
                                </div>
                            </div>
                        </form>
                        
                        <form action="{{ route('installment.saveAmount') }}" method="POST">
                            @csrf
                        
                            <input type="hidden" name="customer_id" value="{{ $customer->id }}">
                        
                            <div class="row mt-4 px-4">
                                <div class="col-md-4">
                                    <label>Will Be Paid</label>
                                    <input type="number"
                                           name="total_will_be_paid"
                                           class="form-control"
                                           required>
                                </div>
                        
                                <div class="col-md-4 mt-4">
                                    <button type="submit" class="btn btn-primary">
                                        Save Amount
                                    </button>
                                </div>
                            </div>
                        </form>

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

<script>
 document.addEventListener('DOMContentLoaded', function () {

    let totalWillBePaid = Number("{{ $totalWillBePaid }}"); // fixed, do NOT change
    let currentPaid = Number("{{ $totalAmount }}"); // current deposited

    let input = document.getElementById('addAmount');

    function updateBalance(inputAmount) {
        let newCurrentPaid = currentPaid + inputAmount; // only this changes
        let balance = totalWillBePaid - newCurrentPaid;

        document.getElementById('currentPaid').innerText = newCurrentPaid.toFixed(2);
        document.getElementById('balance').innerText = Math.abs(balance).toFixed(2);

        let statusText = balance > 0 ? "Due" : (balance < 0 ? "Advance" : "Settled");
        document.getElementById('status').innerText = statusText;
    }

    input.addEventListener('input', function () {
        let inputAmount = parseFloat(this.value) || 0;
        updateBalance(inputAmount);
    });

    // Initialize
    updateBalance(0);
});
</script>



<!-- ALTER TABLE customers
ADD COLUMN auto_installment_status ENUM('on','off') DEFAULT 'off',
ADD COLUMN auto_installment_amount DECIMAL(12,2) DEFAULT 0; -->