@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Income Categories')
@section('content')

<div id="alert">
    @include('components.alert')
</div>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">All Categories</p>
                        <a href="{{ route('income-categories.create') }}" class="btn btn-primary btn-md ms-auto">Create New
                            Categorie</a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        @if ($errors->has('admin_password'))
                        <div class="alert alert-danger">
                            {{ $errors->first('admin_password') }}
                        </div>
                        @endif

                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        #</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Name</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Actions</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($categories as $category)
                                <tr>
                                    <td>{{ $loop->iteration + ($categories->firstItem() - 1) }}</td>
                                    <td>{{ $category->name?? '-' }}</td>
                                    <td>
                                        <div class="dropdown" data-bs-display="static">
                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                                id="actionMenu{{ $category->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                               ⚙️ Actions
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="actionMenu{{ $category->id }}">
                                               
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('income-categories.edit', $category->id) }}">✏️ Edit</a>
                                                </li>
                                               
                                                <li>
                                                    <form action="{{ route('income-categories.destroy', $category->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this category?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">🗑️
                                                            Delete</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>

                                </tr>
                                
                                @endforeach
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center">
                            {{ $categories->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
