@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'User List')
@section('content')

<div id="alert">
    @include('components.alert')
</div>

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <div class="d-flex align-items-center">
                    <p class="mb-0">User Managment</p>
                    <a href="{{ route('users.create') }}" class="btn btn-primary btn-md ms-auto">Create New User</a>
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Role
                                </th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Address</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Mobile No</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Create Date</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Update Date</th>
                                <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $index => $user)
                            <tr>
                                <td>
                                    <div class="d-flex px-3 py-1">
                                        {{--<div>
                                            <img src="" class="avatar me-3" alt="image">
                                        </div>--}}
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p class="text-sm font-weight-bold mb-0">{{ $user->getRoleNames()->join(', ') }}
                                    </p>
                                    <p class="text-sm text-secondary mb-0">@php
                                    $role = $user->roles->first(); 
                                    @endphp
                                    @if($role)
                                    <a href="{{ route('roles.permissions.edit', $role->id) }}">
                                        Permissions
                                    </a>
                                    @endif
                                </p>
                                    
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-sm font-weight-bold mb-0">{{ $user->address }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-sm font-weight-bold mb-0">{{ $user->mobile_number }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-sm font-weight-bold mb-0">{{ $user->created_at }}</p>
                                </td>
                                <td class="align-middle text-center text-sm">
                                    <p class="text-sm font-weight-bold mb-0">{{ $user->updated_at }}</p>
                                </td>
                                <td class="align-middle text-end">
                                    <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                        <p class="text-sm font-weight-bold mb-0"><a
                                                href="{{ route('users.edit', $user->id) }}" class="btn btn-sm">Edit</a>
                                        </p>
                                        {{--<p class="text-sm font-weight-bold mb-0 ps-2">
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-warning">Delete</button>
                                        </form>
                                        </p>--}}
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="">No users found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
