@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Edit Project')
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
            <form action="{{ route('projects.update', $project->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Edit Project</p>
                        <button type="submit" class="btn btn-primary btn-sm ms-auto ml-1">Update</button>
                        <a href="{{ route('projects.index') }}" class="btn btn-sm">Cancel</a>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-uppercase text-sm">Project Information</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-control-label">Project Name</label>
                                <input class="form-control" type="text" name="name" value="{{ old('name', $project->name) }}" placeholder="Project Name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address" class="form-control-label">Address</label>
                                <input class="form-control" type="text" name="address" value="{{ old('address', $project->address) }}" placeholder="Project Address">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="note" class="form-control-label">Note</label>
                                <textarea name="note" class="form-control" rows="4" placeholder="Project Note">{{ old('note', $project->note) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
