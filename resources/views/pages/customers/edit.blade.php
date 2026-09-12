@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Edit Customer')
@section('content')

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            <form action="{{ route('customers.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Edit Customer</p>
                        <button type="submit" class="btn btn-primary btn-sm ms-auto ml-1">Update Customer</button>
                        <a href="{{ route('customers.index') }}" class="btn btn-sm">Cancel</a>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-uppercase text-sm">Update Customer Information</p>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Serial No <span class="text-danger">*</span></label>
                                <input type="number" name="serial_no" class="form-control"
                                       value="{{ old('serial_no', $customer->serial_no) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Name <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="name"
                                    value="{{ old('name', $customer->name) }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Email address</label>
                                <input class="form-control" type="email" name="email"
                                    value="{{ old('email', $customer->email) }}" placeholder="Customer Email Address">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Address</label>
                                <input class="form-control" type="text" name="address"
                                    value="{{ old('address', $customer->address) }}" placeholder="Customer Address">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Flat Quantity</label>
                                <input type="text" name="flat_quantity" class="form-control"
                                value="{{ old('flat_quantity', $customer->flat_quantity) }}" placeholder="Flat Quantity">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Mobile No</label>
                                <input class="form-control" type="text" name="phone"
                                    value="{{ old('phone', $customer->phone) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Profile Image</label>
                                <input type="file" name="profile_image" class="form-control">
                                @if($customer->profile_image)
                                <img src="{{ asset($customer->profile_image) }}" alt="Profile Image" width="100"
                                    height="100" style="object-fit: cover; margin-bottom:10px;">
                                @else
                                <p>No image uploaded.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
