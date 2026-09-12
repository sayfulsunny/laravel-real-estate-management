@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Create Project Expense')
@section('content')

<div id="alert">
    @include('components.alert')
</div>
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> Please fix the following errors:<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <form action="{{ route('expenses.store') }}" method="POST">
                @csrf
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Create Project Expense</p>
                        <button type="submit" class="btn btn-primary btn-sm ms-auto ml-1">Save Expense</button>
                        <a href="{{ route('expenses.index') }}" class="btn btn-sm">Cancel</a>
                    </div>
                </div>

                <div class="card-body">
                    <p class="text-uppercase text-sm">Project Expense</p>
                    <div class="row">
                        <!-- Project -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Project</label>
                                <select name="project_id" class="form-control" required>
                                    <option value="">-- Select Project --</option>
                                    @foreach ($projects as $project)
                                    <option value="{{ $project->id }}"
                                        {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                        {{ $project->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Expense Name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Expense Name</label>
                                <input type="text" name="expense_name" class="form-control"
                                    value="{{ old('expense_name') }}" required placeholder="Expense Name">
                            </div>
                        </div>

                        <!-- Expense Category -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Expense Category</label>
                                <select name="expense_category_id" class="form-control" required>
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('expense_category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Amount -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Amount</label>
                                <input type="text" name="amount" class="form-control" value="{{ old('amount') }}" placeholder="Amount"
                                    required>
                            </div>
                        </div>

                        <!-- Check No -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Check No</label>
                                <input type="text" name="check_no" class="form-control" value="{{ old('check_no') }}" placeholder="Check No">
                            </div>
                        </div>

                        <!-- Date -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Date</label>
                                <input type="date" name="date" class="form-control"
                                    value="{{ old('date', date('Y-m-d')) }}" required>
                            </div>
                        </div>

                        <!-- Voucher No -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Voucher No</label>
                                <input type="text" name="voucher_no" class="form-control"
                                    value="{{ old('voucher_no') }}" placeholder="Voucher No">
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-control-label">Description (optional)</label>
                                <textarea placeholder="Description" name="description" class="form-control"
                                    rows="3">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>


@endsection
