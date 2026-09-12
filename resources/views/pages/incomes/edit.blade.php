@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Edit Incomes')
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
            <form action="{{ route('incomes.update', $income->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Edit Incomes</p>
                        <button type="submit" class="btn btn-primary btn-sm ms-auto ml-1">Update Income</button>
                        <a href="{{ route('incomes.index') }}" class="btn btn-sm">Cancel</a>
                    </div>
                </div>

                <div class="card-body">
                    <p class="text-uppercase text-sm">Edit Incomes</p>
                    <div class="row">

                        <!-- Incomes Name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Income Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $income->name) }}" required>
                            </div>
                        </div>

                          <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Project</label>
                                <select name="project_id" class="form-control" required>
                                    <option value="">-- Select Project --</option>
                                    @foreach ($projects as $project)
                                    <option value="{{ $project->id }}"
                                        {{ $income->project_id == $project->id ? 'selected' : '' }}>
                                        {{ $project->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                         {{-- Income Category --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Income Category</label>
                            <select name="income_category_id" class="form-control" required>
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('income_category_id', $income->income_category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Amount --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Amount</label>
                            <input type="number" name="amount" step="0.01" class="form-control"
                                   value="{{ old('amount', $income->amount) }}" placeholder="Amount" required>
                        </div>
                    </div>

                    {{-- Date --}}
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Date</label>
                            <input type="date" name="date" class="form-control"
                                   value="{{ old('date', \Carbon\Carbon::parse($income->date)->format('Y-m-d')) }}" required>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-control-label">Description (optional)</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Description">{{ old('description', $income->description) }}</textarea>
                        </div>
                    </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>


@endsection
