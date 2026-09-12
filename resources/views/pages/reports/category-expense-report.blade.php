@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Category-wise Expense Repor')
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
                        <p class="mb-0">Category-wise Expense Report</p>

                    </div>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    <form method="GET" action="{{ route('category.expense.report') }}" class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label for="from_date" class="form-label">From Date</label>
                            <input type="date" name="from_date" id="from_date" class="form-control"
                                value="{{ request('from_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="to_date" class="form-label">To Date</label>
                            <input type="date" name="to_date" id="to_date" class="form-control"
                                value="{{ request('to_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="project_id" class="form-label">Project</label>
                            <select name="project_id" id="project_id" class="form-select">
                                <option value="">All Projects</option>
                                @foreach(\App\Models\Project::all() as $project)
                                <option value="{{ $project->id }}"
                                    {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                    {{ $project->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary me-2">Filter</button>
                            <a href="{{ route('category.expense.report') }}" class="btn btn-secondary">Reset</a>
                            <a href="#" onclick="printExpneseReport()" class="btn btn-secondary ms-2">
                                🖨️ Print Report
                            </a>
                        </div>
                    </form>
                    <div class="card-body px-0 pt-0 pb-2">

                        <div id="printable-expense-report">
                            <div class="invoice-header">
                                <h2>Darut Tawhid Complex</h2>
                                <h6 class="invoice-date">Address: Kha Para Road, Tongi, Gazipur</h6>
                            </div>
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Total Expense</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($categoryExpenses as $item)
                                        <tr>
                                            <td>{{ $item['category_name'] }}</td>
                                            <td>{{ number_format($item['total_amount'], 2) }}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td><strong>Total</strong></td>
                                            <td><strong>{{ number_format($totalExpense, 2) }}</strong></td>
                                        </tr>
                                    </tbody>
                                </table>

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
