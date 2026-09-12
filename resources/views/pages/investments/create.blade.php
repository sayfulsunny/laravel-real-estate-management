@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Create Installment Plan')
@section('content')

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Validation Errors:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form method="POST" action="{{ route('investments.store') }}">
                @csrf

                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Create Installment</p>
                        <button type="submit" class="btn btn-primary btn-sm ms-auto ml-1">Create</button>
                        <a href="{{ route('investments.index') }}" class="btn btn-sm">Cancel</a>
                    </div>
                </div>

                <div class="card-body">
                    <p class="text-uppercase text-sm">Installment Plan</p>
                    <div class="row">
                        <!-- Project Selection -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Select Project <span
                                        class="text-danger">*</span></label>
                                <select name="project_id" class="form-control" required>
                                    <option value="">Select Project</option>
                                    @foreach ($projects as $project)
                                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Customer Selection -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Select Customer <span
                                        class="text-danger">*</span></label>
                                <select name="customer_id" class="form-control" required>
                                    <option value="">Select Customer</option>
                                    @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Amount -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Installment Amount <span
                                        class="text-danger">*</span></label>
                                <input type="number" name="amount" class="form-control" required placeholder="enter amount">
                            </div>
                        </div>

                        <!-- Invoice No -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Invoice Number</label>
                                <input type="text" name="invoice_no" class="form-control" placeholder="Invoice number">
                            </div>
                        </div>

                        <!-- Purpose -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Purpose</label>
                                <input type="text" name="purpose" class="form-control" placeholder="Purpose">
                            </div>
                        </div>
                        
                        <!-- Flat no -->
                        <!-- <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Flat/Share No:</label>
                                <input type="text" name="flat_no" class="form-control" placeholder="Flat/Share No:">
                            </div>
                        </div> -->

                        <!-- Check No -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Payment method/Check no</label>
                                <input type="text" name="check_no" class="form-control" placeholder="Payment method/Check Number">
                            </div>
                        </div>

                        <!-- Date -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Date</label>
                                 <input type="date" name="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
