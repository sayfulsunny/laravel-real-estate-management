@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Incomes')
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
                        <p class="mb-0">All Incomes</p>
                        <a href="{{ route('incomes.create') }}" class="btn btn-primary btn-md ms-auto">Create New
                            Income</a>
                             <a href="#" onclick="printIncomeReport()" class="btn btn-secondary ms-2">
                                         Print Report
                                    </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        @if ($errors->has('admin_password'))
                        <div class="alert alert-danger">
                            {{ $errors->first('admin_password') }}
                        </div>
                        @endif
                        
                        <div id="printable-income-report">
                            <div class="invoice-header">
                            <h2>Darut Tawhid Complex</h2>
                            <h6 class="invoice-date">Address: Kha Para Road, Tongi, Gazipur</h6>
                        </div>

                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        #</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Name</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Project</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Category</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Date</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Amount</th>
                                    
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Description</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 print-hidden">
                                        Actions</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                 @foreach ($incomes as $income)
                                <tr>
                                    <td>{{ $incomes->firstItem() + $loop->index }}</td>
                                    <td>{{ $income->name ?? '-' }}</td>
                                    <td>{{ $income->project->name ?? '-' }}</td>
                                    <td>{{ $income->category->name ?? '-' }}</td>
                                    <td>{{ $income->date  }}</td>
                                    <td><span class="badge badge-sm bg-gradient-info">{{ $income->amount }}</span>
                                    </td>
                                    <td class="desc-wrap">{{ $income->description  ?? '—' }}</td>
                                    <td class="print-hidden">
                                        <div class="dropdown" data-bs-display="static">
                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                                id="actionMenu{{ $income->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                               ⚙️ Actions
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="actionMenu{{ $income->id }}">
                                                
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('incomes.invoice', $income->id) }}">🧾 View Invoice</a>
                                                </li>
                                               
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('incomes.edit', $income->id) }}">✏️ Edit</a>
                                                </li>
                                               
                                                <li>
                                                    <form action="{{ route('incomes.destroy', $income->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this income?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">🗑️
                                                            Delete</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>

                                </tr>
                                
                                @endforeach
                            </tbody>
                        </table>
                        </div>

                        <div class="d-flex justify-content-center">
                            {{ $incomes->links('pagination::bootstrap-4') }}
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
    }

    #printable-income-report {
        width: 100% !important;
        margin: 0;
        padding: 0;
    }

    table {
        width: 100% !important;
        border-collapse: collapse !important;
        font-size: 12px;
    }

    table th,
    table td {
        border: 1px solid #444 !important;
        padding: 6px !important;
        text-align: left !important;
        vertical-align: top !important;
    }

    .invoice-header {
        text-align: center;
        border-bottom: 2px solid #000 !important;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .invoice-header h2 {
        font-size: 22px !important;
        margin-bottom: 5px;
    }

    .invoice-date {
        font-size: 13px !important;
    }
    .desc-wrap {
        white-space: normal !important;
        overflow-wrap: anywhere !important;
        max-width: 100% !important;
    }
    .card,
    .table-responsive {
        box-shadow: none !important;
        background: white !important;
    }

    body {
        background: white !important;
        margin: 0 !important;
        padding: 0 !important;
    }
}

</style>

<script>
    function printIncomeReport() {
        const printContents = document.getElementById('printable-income-report').innerHTML;
        const originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;

        window.location.reload();
    }

</script>
