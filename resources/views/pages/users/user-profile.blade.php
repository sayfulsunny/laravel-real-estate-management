@extends('layouts.master', ['class' => 'g-sidenav-show bg-gray-100'])
@section('title', 'Profile')
@section('content')
   
 
    <div id="alert">
        @include('components.alert')
    </div>
    
        <div class="row mt-4 mx-4">
            <div class="col-md-8">
                <div class="card">
                    <form role="form" method="POST" action={{ route('profile.update') }} enctype="multipart/form-data">
                        @csrf
                        <div class="card-header pb-0">
                            <div class="d-flex align-items-center">
                                <p class="mb-0">Edit Profile</p>
                                <button type="submit" class="btn btn-primary btn-sm ms-auto">Save</button>
                                <a href="{{ route('users.index') }}" class="btn btn-sm">Cancel</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="text-uppercase text-sm">User Information</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Username</label>
                                        <input class="form-control" type="text" name="name" value="{{ old('name', auth()->user()->name) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input" class="form-control-label">Email address</label>
                                        <input class="form-control" type="email" name="email" value="{{ old('email', auth()->user()->email) }}">
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
                                        <input class="form-control" type="text" name="city" value="{{ old('city', auth()->user()->city) }}">
                                    </div>
                                </div>
                               
                                
                            </div>
                           
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-profile">
                    <img src="{{ asset('assets/img/profile-layout-header.jpg') }}" alt="Image placeholder" class="card-img-top">
                    <div class="row justify-content-center">
                        <div class="col-4 col-lg-4 order-lg-2">
                            <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
                                <a href="javascript:;">
                                    <img src="{{ asset('assets/img/profile-layout-header.jpg') }}"
                                        class="rounded-circle img-fluid border border-2 border-white">
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body pt-0">
                        
                        <div class="text-center mt-4">
                            <h5>
                                {{ auth()->user()->name ?? 'Name' }}
                            </h5>
                            <div class="h6 font-weight-300">
                           Role(s):</strong> {{ $user->getRoleNames()->join(', ') }}<br>
                                Email:</strong> {{ $user->email }}</p>
                            </div>
                            <div class="h6 mt-4">
                                Mobile no
                            </div>
                            <div>
                                Address
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
@endsection
