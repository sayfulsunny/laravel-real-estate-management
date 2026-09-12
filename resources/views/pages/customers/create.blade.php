@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Create New Customer')
@section('content')

<div class="row mt-4 mx-4">
    <div class="col-12">
        <div class="card mb-4">
            @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Validation Errors:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Create New Customer</p>
                        <button type="submit" class="btn btn-primary btn-sm ms-auto ml-1">Save</button>
                        <a href="{{ route('customers.index') }}" class="btn btn-sm">Cancel</a>
                    </div>
                </div>
                <div class="card-body">
                    <p class="text-uppercase text-sm">Customer Information</p>
                    <div class="row">
                        
                        <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-control-label">Serial No <span class="text-danger">*</span></label>
                            <input type="number" name="serial_no" class="form-control" placeholder="Serial Number">
                        </div>
                    </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Name <span
                                        class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="name" value="" placeholder="Customer Name"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Email address</label>
                                <input class="form-control" type="email" name="email" value=""
                                    placeholder="Customer Email Address">
                            </div>
                        </div>
                       
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Address</label>
                                <input class="form-control" type="text" name="address" value=""
                                    placeholder="Customer Address">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Mobile No</label>
                                <input class="form-control" type="text" name="phone" value=""
                                    placeholder="Customer Mobile No">
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Flat Quantity</label>
                                <input type="text" name="flat_quantity" class="form-control" placeholder="Flat Quantity">
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input" class="form-control-label">Profile Image</label>
                                <input type="file" name="profile_image" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.querySelector('input[name="profile_image"]').addEventListener('change', function (e) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const img = document.getElementById('image-preview');
            if (!img) {
                const preview = document.createElement('img');
                preview.id = 'image-preview';
                preview.src = e.target.result;
                preview.style.maxWidth = '150px';
                preview.style.marginTop = '10px';
                e.target.closest('.mb-3').appendChild(preview);
            } else {
                img.src = e.target.result;
            }
        };
        reader.readAsDataURL(e.target.files[0]);
    });

</script>


@endsection
