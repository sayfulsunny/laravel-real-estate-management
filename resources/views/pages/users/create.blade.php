@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'User Create')
@section('content')

<div id="alert">
    @include('components.alert')
</div>
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Create User</p>
                        <button type="submit" class="btn btn-primary btn-sm ms-auto ml-1">Save</button>
                        <a href="{{ route('users.index') }}" class="btn btn-sm">Cancel</a>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-uppercase text-sm">User Information</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Name</label>
                                <input class="form-control" type="text" name="name" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Email address</label>
                                <input class="form-control" type="email" name="email" value="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Password</label>
                                <input class="form-control" type="password" id="password" name="password" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Confirm Password</label>
                                <input class="form-control" type="password" id="password_confirmation"
                                    name="password_confirmation" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Role</label>
                                <select id="role" name="role" class="form-select" required>
                                    <option value="">Select a role</option>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->name }}"
                                        {{ old('role') == $role->name ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr class="horizontal dark">
                    <p class="text-uppercase text-sm">Contact Information</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Address</label>
                                <input class="form-control" type="text" name="address"
                                    value="{{ old('address', auth()->user()->address) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Mobile No</label>
                                <input class="form-control" type="text" name="city"
                                    value="">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
