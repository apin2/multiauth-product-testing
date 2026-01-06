@extends('admin.layouts.app')

@section('title', 'Edit Customer - ' . $customer->name)

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-pencil-square fs-2 me-3"></i>
                        <h4 class="card-title mb-0 flex-grow-1">Edit Customer: {{ $customer->name }}</h4>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="name" class="form-label fw-bold">Full Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', $customer->name) }}" required>
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Update the customer's full name</div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-bold">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email', $customer->email) }}" required>
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Update the customer's email address</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="password" class="form-label fw-bold">New Password (Optional)</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                        <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" 
                                               id="password" name="password" placeholder="Leave blank to keep current password">
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Enter new password or leave blank to keep current</div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label fw-bold">Confirm New Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                        <input type="password" class="form-control form-control-lg" 
                                               id="password_confirmation" name="password_confirmation" placeholder="Confirm new password">
                                    </div>
                                    <div class="form-text">Re-enter the new password for confirmation</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-4 p-3 bg-light rounded">
                                    <div class="form-check form-switch d-flex align-items-center">
                                        <input type="checkbox" class="form-check-input fs-5 me-3" id="is_active" name="is_active" value="1" 
                                               {{ old('is_active', $customer->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="is_active">Customer Account Status</label>
                                    </div>
                                    <div class="form-text ms-5">Toggle to activate/deactivate the customer account</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex gap-3 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg flex-grow-1 py-3">
                                <i class="bi bi-check-circle me-2"></i>Update Customer
                            </button>
                            <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary btn-lg py-3 flex-grow-1">
                                <i class="bi bi-arrow-left me-2"></i>Back to Customers
                            </a>
                            <button type="button" class="btn btn-danger btn-lg flex-grow-1 py-3" onclick="confirmDelete({{ $customer->id }})">
                                <i class="bi bi-trash me-2"></i>Delete Customer
                            </button>
                        </div>
                        
                        <form id="delete-form-{{ $customer->id }}" action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection