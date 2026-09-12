@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Project Expenses')
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
                        <p class="mb-0">All Project Expenses</p>
                        <a href="{{ route('expenses.create') }}" class="btn btn-primary btn-md ms-auto">Create New
                            Project Expenses</a>
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
                                        Project</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Category</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Name</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Amount</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Check No</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Voucher No</th>
                                    <th
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Status</th>
                                    <th
                                        class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Actions</th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($expenses as $index => $expense)
                                <tr>
                                    <td>{{ $expenses->firstItem() + $index }}</td>
                                    <td>{{ $expense->project->name ?? '-' }}</td>
                                    <td>{{ $expense->category->name ?? '-' }}</td>
                                    <td>{{ $expense->expense_name }}</td>
                                    <td><span class="badge badge-sm bg-gradient-info">{{ $expense->amount }}</span>
                                    </td>
                                    <td>{{ $expense->check_no ?? '—' }}</td>
                                    <td>{{ $expense->voucher_no ?? '—' }}</td>
                                    <td>
                                        @if ($expense->is_approved)
                                        <span class="badge bg-success">Approved</span>
                                        @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown" data-bs-display="static">
                                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                                id="actionMenu{{ $expense->id }}" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                               ⚙️ Actions
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="actionMenu{{ $expense->id }}">
                                                @if (!$expense->is_approved)
                                                <li>
                                                    <!-- Approve Form inside dropdown -->
                                                    <form action="{{ route('expenses.approve', $expense) }}"
                                                        method="POST" class="px-3 py-1">
                                                        @csrf
                                                        <input type="password" name="admin_password"
                                                            class="form-control form-control-sm mb-2"
                                                            placeholder="Admin Password" required>
                                                        <button type="submit"
                                                            class="btn btn-success btn-sm w-100">Approve</button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                @endif

                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('expenses.edit', $expense) }}">✏️ Edit</a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('expenses.invoice', $expense->id) }}"  target="_blank">📄 Invoice</a>
                                                </li>
                                                <li>
                                                    <form action="{{ route('expenses.destroy', $expense) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this expense?')">
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
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No expenses found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-center">
                            {{ $expenses->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
