@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'User Edit')
@section('content')

<div id="alert">
    @include('components.alert')
</div>
<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
             <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Edit User</p>
                        <button type="submit" class="btn btn-primary btn-sm ms-auto ml-1">Update</button>
                        <a href="{{ route('users.index') }}" class="btn btn-sm">Cancel</a>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-uppercase text-sm">User Information</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Name</label>
                                <input class="form-control" type="text" name="name" value="{{ old('name', $user->name) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Email address</label>
                                <input class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">New Password <small>(Leave blank to keep current)</small></label>
                                <input class="form-control" type="password" id="password" name="password">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Role</label>
                               <select name="role" class="form-control" required>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ $userRole === $role->name ? 'selected' : '' }}>
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
                                    value="{{ old('address', $user->address) }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Mobile No</label>
                                <input class="form-control" type="text" name="mobile_number"
                                    value="{{ old('mobile_number', $user->mobile_number) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
