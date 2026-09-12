@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Permissions')
@section('content')

<div id="alert">
    @include('components.alert')
</div>

<div class="container-fluid py-4">
    <div class="row mt-4 mx-4">
        <div class="col-12">
            <div class="card mb-4 p-4">
                <h4 class="mb-4">Manage Permissions for Role: <strong>{{ $role->name }}</strong></h4>

                <form method="POST" action="{{ route('roles.permissions.update', $role->id) }}">
                    @csrf
                    @method('PUT')

                    @php
                        $grouped = [];

                        // Group permissions by last word (assuming last word is module/section)
                        foreach ($permissions as $permission) {
                            $parts = explode(' ', $permission->name);
                            $section = array_pop($parts); // e.g., 'unit'
                            $grouped[$section][] = $permission;
                        }
                    @endphp

                    @foreach ($grouped as $section => $perms)
                        <div class="mb-4 border rounded p-3 bg-light">
                            <h6 class="text-uppercase text-secondary mb-3">
                                <i class="fas fa-folder-open me-2"></i> Select Section: <strong>{{ ucfirst($section) }}</strong>
                            </h6>

                            <div class="row">
                                @foreach ($perms as $permission)
                                    <div class="col-md-4">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" 
                                                name="permissions[]" 
                                                value="{{ $permission->name }}"
                                                id="perm_{{ $permission->id }}"
                                                {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                {{ ucfirst($permission->name) }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <button type="submit" class="btn btn-primary mt-3">Update Permissions</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
