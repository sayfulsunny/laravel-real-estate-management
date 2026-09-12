@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Project List')
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
                        <p class="mb-0">Project List</p>
                        <a href="{{ route('projects.create') }}" class="btn btn-primary btn-md ms-auto">Create New
                            Project</a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        @if($projects->count())
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        ID</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Name</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Address</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Note</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Actions</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projects as $project)
                                <tr>
                                    <td>
                                        {{ $project->id }}
                                    </td>
                                    <td>
                                        <h6 class="mb-0 text-sm">{{ $project->name }}</h6>
                                    </td>

                                    <td class="align-middle text-center">
                                        {{ $project->address }}
                                    </td>

                                    <td>
                                        {{ $project->note }}
                                    </td>

                                    <td class="align-middle">
                                        <div class="dropdown" data-bs-display="static">
                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                                id="projectActions{{ $project->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                ⚙️ Actions
                                            </button>
                                            <ul class="dropdown-menu"
                                                aria-labelledby="projectActions{{ $project->id }}">
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('projects.edit', $project) }}">
                                                        ✏️ Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('projects.statement', $project->id) }}">
                                                        📊 Statement
                                                    </a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('projects.destroy', $project) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this project?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            🗑️ Delete
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p>No projects found.</p>
                        @endif
                        <div class="d-flex justify-content-center">
                            {{ $projects->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
