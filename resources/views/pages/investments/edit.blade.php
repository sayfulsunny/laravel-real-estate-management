@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Edit Installment Plan')
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
            <form action="{{ route('investments.update', [$customer->id, $project->id]) }}" method="POST">
        @csrf
        @method('PUT')

                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Edit Installment</p>
                        <button type="submit" class="btn btn-primary btn-sm ms-auto ml-1">Update</button>
                        <a href="{{ route('investments.index') }}" class="btn btn-sm">Cancel</a>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-uppercase text-sm">Installment Plan</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Project<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="project" value="{{ $project->name }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Customer <span
                                        class="text-danger">*</span></label>
                               <input type="text" class="form-control" id="customer" value="{{ $customer->name }}" readonly>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Installment Amount<span
                                        class="text-danger">*</span></label>
                                <input type="number" name="amount" id="amount" class="form-control" step="0.01" min="0" required
                   value="{{ old('amount', $project->pivot->amount) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
