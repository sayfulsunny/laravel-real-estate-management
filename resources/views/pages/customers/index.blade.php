@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Customers List')
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
                        <p class="mb-0">Customers List</p>
                        <a href="{{ route('customers.create') }}" class="btn btn-primary btn-md ms-auto">Create New
                            Customer</a>
                        <a href="#" onclick="printCustomerTable()" class="btn btn-secondary mb-3">
                            🖨️ Print Customers
                        </a>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('customers.index') }}" class="row mb-3">
                            <div class="col-md-4">
                                <input type="text" name="name" class="form-control" placeholder="Search by Name"
                                    value="{{ request('name') }}">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="phone" class="form-control" placeholder="Search by Phone"
                                    value="{{ request('phone') }}">
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary">🔍 Filter</button>
                                <a href="{{ route('customers.index') }}" class="btn btn-secondary">❌ Reset</a>
                            </div>
                        </form>
                    </div>
                    
                    {{--<form action="{{ route('customers.add-auto-installment') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            Add Auto Installment
                        </button>
                    </form> --}}

                </div>
                <div id="printable-customer-table">
                     <div class="invoice-header">
                            <h2>Darut Tawhid Complex</h2>
                            <h6 class="invoice-date">Address: Kha Para Road, Tongi, Gazipur</h6>
                        </div>
                <div class="row">
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Profile Image</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Name</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Email</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Phone</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Flat Quantity</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Serial No</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Address</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Total Inatallment
                                        </th>

                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 no-print">
                                            Actions</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($customers as $customer)
                                    <tr>
                                        <td>
                                            @if($customer->profile_image)
                                            <img src="{{ asset($customer->profile_image) }}" alt="Profile Image"
                                                width="60" height="60" style="object-fit: cover; border-radius: 50%;">
                                            @else
                                            <span>No Image</span>
                                            @endif
                                        </td>
                                        <td>
                                            <h6 class="mb-0 text-sm">{{ $customer->name }}</h6>
                                        </td>
                                        <td>
                                            {{ $customer->email ?? '-' }}
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $customer->phone ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $customer->flat_quantity ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $customer->serial_no ?? '-' }}</p>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="badge badge-sm bg-gradient-success">{{ $customer->address ?? '-' }}</span>
                                        </td>
                                        <td class="text-center">
                                            {{ number_format($customer->investments_sum_amount, 2) }} BDT
                                        </td>

                                        <td>
                                            <div class="dropdown" data-bs-display="static">
                                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                                    id="actionMenu{{ $customer->id }}" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    ⚙️ Actions
                                                </button>
                                                <ul class="dropdown-menu"
                                                    aria-labelledby="actionMenu{{ $customer->id }}">

                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('customers.edit', $customer->id) }}">✏️
                                                            Edit</a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('customers.investments', $customer->id) }}"
                                                            target="_blank">📄 Report</a>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('customers.destroy', $customer->id) }}"
                                                            method="POST" style="display:inline-block;"
                                                            onsubmit="return confirm('Are you sure want to delete this customer?');">
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
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No customers found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {{ $customers->appends(request()->query())->links('pagination::bootstrap-4') }}
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

        .btn,
        .dropdown,
        nav,
        .pagination,
        .card-header,
        .action-buttons {
            display: none !important;
        }

        img {
            max-width: 60px;
            max-height: 60px;
            object-fit: cover;
            border-radius: 50%;
        }

        body {
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse !important;
        }

        th,
        td {
            /* border: 1px solid #000 !important; */
            padding: 8px !important;
            font-size: 12px !important;
        }
        .no-print{
            display:none;
        }
    }

</style>


<script>
    function printCustomerTable() {
        const printContents = document.getElementById('printable-customer-table').innerHTML;
        const originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload(); // reload to restore JS events and CSS
    }

</script>
