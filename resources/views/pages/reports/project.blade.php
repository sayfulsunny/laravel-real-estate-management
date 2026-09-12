@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Project Report')

@section('content')
<div id="alert">
    @include('components.alert')
</div>


<div class="container-fluid py-4">
    <div class="row">
        {{-- Project Selection Form --}}
        <div class="col-md-12 mt-4">
            <div class="card mb-4">
                <div class="px-3 py-3">
                    <form action="{{ route('project.report.generate') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <label for="project_id">Select Project:</label>
                                <select name="project_id" id="project_id" class="form-control selectpicker"
                                    data-live-search="true" data-size="10" required>
                                    <option value="">-- Select Project --</option>
                                    @foreach($projects as $proj)
                                    <option value="{{ $proj->id }}"
                                        {{ isset($project) && $project->id == $proj->id ? 'selected' : '' }}>
                                        {{ $proj->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>From Date:</label>
                                <input type="date" name="start_date" class="form-control"
                                    value="{{ request('start_date') }}">
                            </div>

                            <div class="col-md-3">
                                <label>To Date:</label>
                                <input type="date" name="end_date" class="form-control"
                                    value="{{ request('end_date') }}">
                            </div>

                            <div class="col-md-3 d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-primary">Generate</button>
                                <a href="{{ route('report.project') }}" class="btn btn-secondary">Reset</a>
                                <a href="#" onclick="printProjectReport()" class="btn btn-secondary ms-2">
                                    🖨️ Print Report
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="printable-project-report">
        <div class="invoice-header">
            <h2>Darut Tawhid Complex</h2>
            <h6 class="invoice-date">Address: Kha Para Road, Tongi, Gazipur</h6>
        </div>
        <div class="row">

            {{-- BALANCE CARD --}}
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header pb-0 px-3">
                        <h6 class="mb-0">Balance for "{{ $project->name ?? '-' }}"</h6>
                    </div>

                    <div class="card-body pt-4 p-3">
                        <h4>
                            Opening balance:
                            <span class="{{ $previousBalance >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ number_format($previousBalance, 2) }}
                            </span>
                        </h4>
                        <h4>
                            Current Balance (Filtered):
                            <span class="{{ $currentBalance >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ number_format($currentBalance, 2) }}
                            </span>
                        </h4>
                        <hr>
                        <h3>
                            Total Balance:
                            <span class="{{ $totalBalance >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ number_format($totalBalance, 2) }}
                            </span>
                        </h3>

                        <p class="text-muted">
                            (Opening balance + Total Investment + Total Income - Total Expense)
                        </p>

                    </div>
                </div>
            </div>

        </div>

        {{-- Report Section --}}
        @isset($project)
        <div class="row">
            {{-- Investments --}}
            <div class="col-md-6 mt-4">
                <div class="card">
                    <div class="card-header pb-0 px-3">
                        <h6 class="mb-0">Investments for "{{ $project->name }}"</h6>
                    </div>
                    <div class="card-body pt-4 p-3">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Date</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Customer</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($investments as $investment)
                                    <tr>
                                        <td class="text-xs ps-2">
                                            {{ \Carbon\Carbon::parse($investment['date'])->format('Y-m-d') }}
                                        </td>
                                        <td class="text-xs ps-2">
                                            {{ $investment->customer->name ?? 'N/A' }}
                                        </td>
                                        <td class="text-xs ps-2">
                                            {{ number_format($investment->amount, 2) }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">No investments found.</td>
                                    </tr>
                                    @endforelse
                                    <tr class="border-top">
                                        <th>Total Investment</th>
                                        <th>{{ number_format($totalInvestment, 2) }}</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Incomes --}}
            <div class="col-md-6 mt-4">
                <div class="card h-100 mb-4">
                    <div class="card-header pb-0 px-3">
                        <h6 class="mb-0">Incomes for "{{ $project->name }}"</h6>
                    </div>
                    <div class="card-body pt-4 p-3">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Date</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Name</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($incomes as $income)
                                    <tr>
                                        <td class="text-xs ps-2">
                                            {{ \Carbon\Carbon::parse($income['date'])->format('Y-m-d') }}
                                        </td>
                                        <td class="text-xs ps-2">
                                            {{ $income->name }}
                                        </td>
                                        <td class="text-xs ps-2">
                                            {{ number_format($income->amount, 2) }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No incomes found.</td>
                                    </tr>
                                    @endforelse
                                    <tr class="border-top">
                                        <th>Total Income</th>
                                        <th colspan="2">{{ number_format($totalIncome, 2) }}</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Expenses --}}
            <div class="col-md-6 mt-4">
                <div class="card h-100 mb-4">
                    <div class="card-header pb-0 px-3">
                        <h6 class="mb-0">Expenses for "{{ $project->name }}"</h6>
                    </div>
                    <div class="card-body pt-4 p-3">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Date</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Expense Name</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($expenses as $expense)
                                    <tr>
                                        <td class="text-xs ps-2">
                                            {{ \Carbon\Carbon::parse($expense['date'])->format('Y-m-d') }}
                                        </td>
                                        <td class="text-xs ps-2">
                                            {{ $expense->expense_name }}
                                        </td>
                                        <td class="text-xs ps-2">
                                            {{ number_format($expense->amount, 2) }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">No expenses found.</td>
                                    </tr>
                                    @endforelse
                                    <tr class="border-top">
                                        <th>Total Expense</th>
                                        <th>{{ number_format($totalExpense, 2) }}</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endisset
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

</style>
<script>
    $(document).ready(function () {
        $('#project_id').select2({
            placeholder: '-- Select Project --',
            allowClear: true
        });
    });

</script>

<script>
    function printProjectReport() {
        const printContents = document.getElementById('printable-project-report').innerHTML;
        const originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;

        // Optional: Reload the page to restore event listeners and layout
        window.location.reload();
    }

</script>
