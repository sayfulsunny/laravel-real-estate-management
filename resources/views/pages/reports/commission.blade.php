@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Commission Report')
@section('content')

<div id="alert">
    @include('components.alert')
</div>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Commission Report</p>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="px-3 py-3">
                        <form method="GET" action="{{ route('commission.report') }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control"
                                        value="{{ request('start_date') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control"
                                        value="{{ request('end_date') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="end_date" class="form-label">Project</label>
                                    <select name="project_id" class="form-control">
                                        <option value="">-- All --</option>
                                        @foreach(\App\Models\Project::all() as $project)
                                        <option value="{{ $project->id }}"
                                            {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                            {{ $project->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="{{ route('commission.report') }}" class="btn btn-outline-secondary ms-2">
                                        ❌ Clear
                                    </a>
                                    {{--<a href="{{ route('commission.report.download', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}"
                                    class="btn btn-success ms-2">
                                    📥 Download Report
                                    </a>--}}
                                    <a href="#" onclick="printCommissionReport()" class="btn btn-secondary ms-2">
                                        🖨️ Print Report
                                    </a>
                                    <a href="#" onclick="printCommissionSummary()" class="btn btn-info ms-2">
                                        🖨️ Print Summary
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="printable-commission-report">
                        <div class="invoice-header" id="commission-print-header">
                            <h2>Darut Tawhid Complex</h2>
                            <h6 class="invoice-date">Address: Kha Para Road, Tongi, Gazipur</h6>
                        </div>
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Date</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Project Name</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Total Expense</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Commission (8%)</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 print-hidden">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($commissions as $data)
                                    @php
                                    $alreadyWithdrawn = \App\Models\CommissionWithdrawal::where('project_id',
                                    $data->project_id)
                                    ->where('commission_date', $data->date)
                                    ->exists();
                                    @endphp

                                    <tr>
                                        <td>{{ $data->date }}</td>
                                        <td>{{ $data->project_name }}</td>
                                        <td>{{ number_format($data->amount, 2) }} ৳</td>
                                        <td>{{ number_format($data->commission, 2) }} ৳</td>
                                        <td class="align-middle print-hidden">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                                    id="actionMenu{{ $data->project_id }}{{ $data->id }}"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <ul class="dropdown-menu"
                                                    aria-labelledby="actionMenu{{ $data->project_id }}{{ $data->id }}">
                                                    <li>
                                                        @if (!$alreadyWithdrawn)
                                                        <form action="{{ route('commission.withdraw') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="project_id"
                                                                value="{{ $data->project_id }}">
                                                            <input type="hidden" name="commission_date"
                                                                value="{{ $data->date }}">
                                                            <input type="hidden" name="amount"
                                                                value="{{ $data->commission }}">
                                                            <button type="submit" class="dropdown-item">💰
                                                                Withdraw</button>
                                                        </form>
                                                        @else
                                                        <span class="badge bg-secondary ms-3">📄 Withdrawn</span>
                                                        @endif
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('project.commission.summary', $data->project_id) }}">
                                                            📊 View Summary
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5">No commission data available.</td>
                                    </tr>
                                    @endforelse

                                <tfoot id="commission-print-footer">
                                <tr>
                                    <th colspan="1" class="text-end">Total Expense</th>
                                    <th>{{ number_format($totalExpense, 2) }} ৳</th>
                                    <th colspan="1" class="text-end">Total Commission (8%)</th>
                                    <th>{{ number_format($totalCommission, 2) }} ৳</th>
                                    <th></th>
                                </tr>
                            </tfoot>



                            </table>

                            <div class="d-flex justify-content-center">
                                {{ $commissions->appends(request()->query())->links('pagination::bootstrap-4') }}

                            </div>
                        </div>
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
    .print-hidden {
        display: none !important;
        visibility: hidden !important;
    }
        
    }
</style>

<script>
    function printCommissionReport() {
        const printContents = document.getElementById('printable-commission-report').innerHTML;
        const originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;

        // Optional: Reload the page to restore event listeners and layout
        window.location.reload();
    }

</script>

<script>
    function printCommissionSummary() {
    const header = document.getElementById('commission-print-header').outerHTML;
    const footer = document.getElementById('commission-print-footer').outerHTML;

    const printContent = `
        <div style="width:100%; padding:20px;">
            ${header}
            <table style="width:100%; border-collapse:collapse; margin-top:30px;">
                ${footer}
            </table>
        </div>
    `;

    const originalContents = document.body.innerHTML;

    document.body.innerHTML = printContent;
    window.print();
    document.body.innerHTML = originalContents;

    window.location.reload();
}

</script>

