@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Commission Withdrawal History')
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
                        <p class="mb-0">Commission Withdrawal History</p>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                   {{-- <div class="px-3 py-3">
                        <form method="GET" action="{{ route('commission.report') }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" name="start_date" id="start_date" class="form-control"
                                        value="{{ request('start_date') ?? now()->startOfMonth()->toDateString() }}">
                                </div>
                                <div class="col-md-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" name="end_date" id="end_date" class="form-control"
                                        value="{{ request('end_date') ?? now()->toDateString() }}">
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>--}}

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Withdraw Date</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Project</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Commission Date</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Amount </th>
                                </tr>
                            </thead>
                           <tbody>
                                @forelse($withdrawals as $withdrawal)
                                    <tr>
                                        <td>{{ $withdrawal->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $withdrawal->project->name ?? '-' }}</td>
                                        <td>{{ $withdrawal->commission_date }}</td>
                                        <td>{{ number_format($withdrawal->amount, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">No withdrawal history available.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center">
                            {{ $withdrawals->links() }} {{-- Laravel pagination --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
