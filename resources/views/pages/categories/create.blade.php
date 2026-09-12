@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Create Expense Category')
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
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Create Expense Category</p>
                        <button type="submit" class="btn btn-primary btn-sm ms-auto ml-1">Save</button>
                        <a href="{{ route('categories.index') }}" class="btn btn-sm">Cancel</a>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-uppercase text-sm">Expense Category</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Category Name</label>
                                <input type="text" name="name" class="form-control" placeholder="e.g. Materials"
                                    value="{{ old('name') }}" required>
                                @error('name')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>


                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
