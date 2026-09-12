@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Expense Report')
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
                        <p class="mb-0">Expense Report</p>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="px-3 py-3">
                        <form method="GET" action="{{ route('expense.report') }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" name="from_date" class="form-control"
                                        value="{{ request('from_date') }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" name="to_date" class="form-control"
                                        value="{{ request('to_date') }}">
                                </div>
                                <div class="col-md-3">
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
                                <div class="col-md-3">
                                    <label for="end_date" class="form-label">Expense Category</label>
                                    <select name="expense_category_id" class="form-control">
                                        <option value="">-- All --</option>
                                        @foreach(\App\Models\ExpenseCategory::all() as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('expense_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex align-items-end mt-2">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="#" onclick="printExpneseReport()" class="btn btn-secondary ms-2">
                                        🖨️ Print Report
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                        <div id="printable-expense-report">
                            <div class="invoice-header">
                            <h2>Darut Tawhid Complex</h2>
                            <h6 class="invoice-date">Address: Kha Para Road, Tongi, Gazipur</h6>
                        </div>
                    <div class="table-responsive p-0">
                        @if($expenses->count())
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Expense Name</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Voucher No</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Category</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Project</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Amount </th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Date </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($expenses as $expense)
                                <tr>
                                    <td>{{ $expense->expense_name }}</td>
                                    <td>
                                        {{ $expense->voucher_no }} <br>
                                        <span style="font-size: 12px; color:#666;">({{ $expense->id }})</span>
                                    </td>

                                    <td>{{ $expense->expenseCategory->name ?? 'N/A' }}</td>
                                    <td>{{ $expense->project->name ?? 'N/A' }}</td>
                                    <td>{{ number_format($expense->amount, 2) }}</td>
                                    <td>{{ $expense->date }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p>No expenses found.</p>
                        @endif

                        <div class="d-flex justify-content-center">
                            <h3>Total Expense: {{ number_format($totalExpense, 2) }}</h3>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $expenses->links('pagination::bootstrap-4') }}
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
</style>

<script>
    function printExpneseReport() {
        const printContents = document.getElementById('printable-expense-report').innerHTML;
        const originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;

        // Optional: Reload the page to restore event listeners and layout
        window.location.reload();
    }

</script>