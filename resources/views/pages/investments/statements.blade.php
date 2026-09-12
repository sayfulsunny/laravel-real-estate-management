@extends('layouts.master')
@section('title', 'Statements Per Project')

@section('content')
<div class="container-fluid py-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="card print_area">
                <div class="card-header pb-0 px-3">
                    <h4>Statement - {{ $project->name }}</h4>
                    <button class="btn btn-secondary btn-block no-print"
                        onclick="print_receipt('print_area')">Print</button>
                </div>
                <div class="card mb-4">
                    <div class="card-body pt-4 p-3">
                        @if ($project->customers->count())
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach ($project->customers as $customer)
                                <tr>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ number_format($customer->pivot->amount, 2) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($customer->pivot->created_at)->format('d M Y') }}</td>
                                </tr>
                                @php $total += $customer->pivot->amount; @endphp
                                @endforeach
                                <tr>
                                    <th>Total</th>
                                    <th>{{ number_format($total, 2) }}</th>
                                    <th></th>
                                </tr>
                            </tbody>
                        </table>
                        @else
                        <p>No investments found for this project.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .no-print {
        margin-top: 20px;
    }

    @media print {
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

        .no-print {
            display: none !important;
        }
    }

</style>
@endsection


<script>
    function print_receipt(divId) {
        window.print();
    }

</script>
