@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Create Incomes')
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
            <form action="{{ route('incomes.store') }}" method="POST">
                @csrf
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Create Incomes</p>
                        <button type="submit" class="btn btn-primary btn-sm ms-auto ml-1">Save Income</button>
                        <a href="{{ route('incomes.index') }}" class="btn btn-sm">Cancel</a>
                    </div>
                </div>

                <div class="card-body">
                    <p class="text-uppercase text-sm">Incomes</p>
                    <div class="row">

                        <!-- Incomes Name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Income Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name') }}" required placeholder="Income Name">
                            </div>
                        </div>

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

                        <!-- Income Category -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Income Category</label>
                                <select name="income_category_id" class="form-control" required>
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('income_category_id') == $category->id ? 'selected' : '' }}>
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


                        <!-- Date -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Date</label>
                                <input type="date" name="date" class="form-control"
                                    value="{{ old('date', date('Y-m-d')) }}" required>
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
