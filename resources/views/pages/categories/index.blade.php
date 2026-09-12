@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Expense Categories')
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
                        <p class="mb-0">Expense Categories</p>
                        <a href="{{ route('categories.create') }}" class="btn btn-primary btn-md ms-auto">Create
                             Categories</a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        

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
                                    
                                </tr>
                            </thead>
                          <tbody>
                        @forelse ($categories as $index => $category)
                            <tr>
                                <td>{{ $categories->firstItem() + $index }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-warning">Edit</a>

                                    <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this category?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No categories found.</td>
                            </tr>
                        @endforelse
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
