@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Project Create')
@section('content')

<div id="alert">
    @include('components.alert')
</div>
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="{{ route('projects.store') }}" method="POST">
                @csrf
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Create Project</p>
                        <button type="submit" class="btn btn-primary btn-sm ms-auto ml-1">Save</button>
                        <a href="{{ route('projects.index') }}" class="btn btn-sm">Cancel</a>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-uppercase text-sm">Project Information</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Project Name</label>
                                <input class="form-control" type="text" name="name" value="" placeholder="Project Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Address</label>
                                <input class="form-control" type="text" name="address" value="" placeholder="Project Address">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Note</label>
                                <textarea name="note" class="form-control" rows="4" placeholder="Project Note">{{ old('note') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
