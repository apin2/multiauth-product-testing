@extends('admin.layouts.app')

@section('title', $product->name . ' - Product Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">{{ $product->name }}</h2>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Back to Products
                    </a>
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-1"></i>Edit Product
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Product Image</h5>
                </div>
                <div class="card-body text-center">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="img-fluid rounded shadow-sm" 
                             style="max-height: 400px; object-fit: contain;">
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center" 
                             style="height: 300px; border-radius: 0.375rem;">
                            <div class="text-center">
                                <i class="bi bi-image fs-1 text-muted"></i>
                                <p class="text-muted mt-2">No Image Available</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Product Details</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Product Name:</strong>
                        </div>
                        <div class="col-sm-8">
                            <span class="text-dark">{{ $product->name }}</span>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Description:</strong>
                        </div>
                        <div class="col-sm-8">
                            <p class="text-dark">{{ $product->description ?: 'No description provided' }}</p>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Price:</strong>
                        </div>
                        <div class="col-sm-8">
                            <span class="text-success fw-bold fs-5">${{ number_format($product->price, 2) }}</span>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Category:</strong>
                        </div>
                        <div class="col-sm-8">
                            <span class="badge bg-primary fs-6">{{ $product->category }}</span>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Stock:</strong>
                        </div>
                        <div class="col-sm-8">
                            <span class="badge {{ $product->stock > 10 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning' : 'bg-danger') }} fs-6">
                                {{ $product->stock }} in stock
                            </span>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Status:</strong>
                        </div>
                        <div class="col-sm-8">
                            @if($product->stock > 10)
                                <span class="badge bg-success">In Stock</span>
                            @elseif($product->stock > 0)
                                <span class="badge bg-warning">Low Stock</span>
                            @else
                                <span class="badge bg-danger">Out of Stock</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            <strong>Created:</strong>
                        </div>
                        <div class="col-sm-8">
                            <span class="text-muted">{{ $product->created_at->format('M d, Y H:i') }}</span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4">
                            <strong>Updated:</strong>
                        </div>
                        <div class="col-sm-8">
                            <span class="text-muted">{{ $product->updated_at->format('M d, Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Additional Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted">Product ID</h6>
                            <p class="mb-0">{{ $product->id }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">SKU</h6>
                            <p class="mb-0">{{ $product->id }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection