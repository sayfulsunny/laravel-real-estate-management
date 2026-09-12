@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Commission Summary')

@section('content')

<div id="alert">
    @include('components.alert')
</div>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-header bg-gradient-info text-white">
                    <h5 class="mb-0">📊 Commission Summary</h5>
                    <small>Project: <strong>{{ $project->name }}</strong></small>
                </div>

                <div class="card-body">
                    <ul class="list-group list-group-flush">

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>🏗️ <strong>Project Name</strong></span>
                            <span>{{ $project->name }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>💰 <strong>Total Expense</strong></span>
                            <span class="badge bg-info text-dark fs-6">
                                {{ number_format($totalExpense, 2) }} ৳
                            </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>🧮 <strong>Total Commission (8%)</strong></span>
                            <span class="badge bg-primary fs-6">
                                {{ number_format($totalCommission, 2) }} ৳
                            </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>✅ <strong>Commission Withdrawn</strong></span>
                            <span class="badge bg-success fs-6">
                                {{ number_format($withdrawnCommission, 2) }} ৳
                            </span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>⏳ <strong>Commission Remaining</strong></span>
                            <span class="badge bg-danger fs-6">
                                {{ number_format($remainingCommission, 2) }} ৳
                            </span>
                        </li>

                    </ul>

                    <div class="text-end mt-4">
                        <a href="{{ route('commission.report') }}" class="btn btn-outline-secondary">
                            ← Back to Report
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
