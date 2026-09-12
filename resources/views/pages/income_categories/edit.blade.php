@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Edit Incomes Category')
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
           <form action="{{ route('income-categories.update', $income_category->id) }}" method="POST">
    @csrf
    @method('PUT')

                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Edit Incomes</p>
                        <button type="submit" class="btn btn-primary btn-sm ms-auto ml-1">Update Category</button>
                        <a href="{{ route('income-categories.index') }}" class="btn btn-sm">Cancel</a>
                    </div>
                </div>

                <div class="card-body">
                    <p class="text-uppercase text-sm">Edit Category</p>
                    <div class="row">

                        <!-- Incomes Name -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Category Name</label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ $income_category->name }}" required>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>


@endsection
