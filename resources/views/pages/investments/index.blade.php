@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Installment')
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
                        <p class="mb-0">Installment</p>
                        <a href="{{ route('investments.create') }}" class="btn btn-primary btn-md ms-auto">Create New</a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase">#</th>
                                    <th class="text-uppercase">Invoice No</th>
                                    <th class="text-uppercase">Project</th>
                                    <th class="text-uppercase">Customer</th>
                                    <th class="text-uppercase">Amount</th>
                                    <th class="text-uppercase">Date</th>
                                    <th class="text-uppercase">Action</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($investments->count())
                                @foreach($investments as $index => $investment)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $investment->invoice_no ?? 'N/A' }}</td>
                                    <td>{{ $investment->project->name ?? '-' }}</td>
                                    <td>{{ $investment->customer->name }}</td>
                                    <td>{{ number_format($investment->amount, 2) }}</td>
                                  <td>{{ \Carbon\Carbon::parse($investment->date)->format('d-m-Y') }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                                id="actionMenu{{ $investment->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                               ⚙️ Actions
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="actionMenu{{ $investment->id }}">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('investments.invoice', $investment->id) }}" target="_blank">📄 View
                                                        Invoice</a>
                                                </li>
                                                <li>
                                                    <form
                                                        action="{{ route('investments.destroy', $investment->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this installment plan?');">
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
                                @else
                                <tr>
                                    <td colspan="6" class="text-center">No investments found.</td>
                                </tr>
                                @endif
                            </tbody>

                        </table>


                        <div class="d-flex justify-content-center">
                           {{ $investments->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
