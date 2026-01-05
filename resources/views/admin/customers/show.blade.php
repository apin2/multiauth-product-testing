@extends('admin.layouts.app')

@section('title', 'View Customer - ' . $customer->name)

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-person-vcard fs-2 me-3"></i>
                            <h4 class="card-title mb-0">Customer Details: {{ $customer->name }}</h4>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-warning">
                                <i class="bi bi-pencil me-1"></i> Edit
                            </a>
                            <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <div class="card h-100 border-0 bg-light">
                                <div class="card-body">
                                    <h5 class="card-title mb-4 text-primary fw-bold">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Customer Information
                                    </h5>
                                    
                                    <div class="row">
                                        <div class="col-sm-6 mb-3">
                                            <label class="form-label fw-bold text-muted">Customer ID</label>
                                            <p class="form-control-plaintext mb-0 fs-5">{{ $customer->id }}</p>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <label class="form-label fw-bold text-muted">Status</label>
                                            <div class="mb-0">
                                                @if($customer->is_active)
                                                    <span class="badge bg-success fs-6 py-2 px-3">
                                                        <i class="bi bi-check-circle me-1"></i> Active
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning fs-6 py-2 px-3 text-dark">
                                                        <i class="bi bi-x-circle me-1"></i> Inactive
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Full Name</label>
                                        <p class="form-control-plaintext mb-0 fs-5">{{ $customer->name }}</p>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold text-muted">Email Address</label>
                                        <p class="form-control-plaintext mb-0 fs-5">{{ $customer->email }}</p>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-6 mb-3">
                                            <label class="form-label fw-bold text-muted">Member Since</label>
                                            <p class="form-control-plaintext mb-0">{{ $customer->created_at->format('M d, Y') }}</p>
                                        </div>
                                        <div class="col-sm-6 mb-3">
                                            <label class="form-label fw-bold text-muted">Last Updated</label>
                                            <p class="form-control-plaintext mb-0">{{ $customer->updated_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body text-center d-flex flex-column justify-content-center align-items-center p-4">
                                    <div class="mb-4">
                                        <i class="bi bi-person-circle text-primary" style="font-size: 4rem;"></i>
                                    </div>
                                    <h5 class="card-title mb-2">{{ $customer->name }}</h5>
                                    <p class="card-text text-muted mb-3">Customer Account</p>
                                    
                                    <div class="d-grid gap-2 w-100 mt-3">
                                        <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-primary">
                                            <i class="bi bi-pencil me-2"></i>Edit Profile
                                        </a>
                                    </div>
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