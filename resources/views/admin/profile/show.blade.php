@extends('admin.layouts.app')

@section('title', 'Admin Profile')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Admin Profile</h4>
            </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-8">
                                <h5>Profile Information</h5>
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <p class="form-control-plaintext">{{ $admin->name }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <p class="form-control-plaintext">{{ $admin->email }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Member Since</label>
                                    <p class="form-control-plaintext">{{ $admin->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <i class="bi bi-person-circle" style="font-size: 3rem;"></i>
                                        <h5 class="card-title">{{ $admin->name }}</h5>
                                        <p class="card-text text-muted">Admin Account</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection