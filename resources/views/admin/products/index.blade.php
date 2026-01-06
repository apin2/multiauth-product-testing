@extends('admin.layouts.app')

@section('title', 'Products Management')

@section('content')

    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">Products</h2>
            <p class="text-muted mb-0">Manage your product inventory</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.products.import') }}" class="btn btn-outline-secondary">
                <i class="bi bi-upload me-1"></i>Import Products
            </a>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Add Product
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Search Section -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <form method="GET" action="{{ route('admin.products.index') }}" class="d-flex">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Search products..." value="{{ request('search') }}">
                            @if(request('perPage'))
                                <input type="hidden" name="perPage" value="{{ request('perPage') }}">
                            @endif
                        </div>
                        <button type="submit" class="btn btn-outline-secondary ms-2">Search</button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary ms-2">Clear</a>
                    </form>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>S.No.</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Stock</th>
                            <th>Image</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="40" height="40" class="rounded" onerror="this.onerror=null; this.src='{{ asset('storage/products/default-product.svg') }}';">
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $product->name }}</div>
                                            <small class="text-muted">ID: {{ $product->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ strlen($product->description) > 50 ? substr($product->description, 0, 50) . '...' : $product->description }}</td>
                                <td>₹{{ number_format($product->price, 2) }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $product->category }}</span>
                                </td>
                                <td>
                                    <span class="badge {{ $product->stock > 10 ? 'bg-success' : ($product->stock > 0 ? 'bg-warning text-dark' : 'bg-danger') }}">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td>
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="50" height="50" class="rounded" onerror="this.onerror=null; this.src='{{ asset('storage/products/default-product.svg') }}';">
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-outline-info" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirmDeleteProduct(event)" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                    No products found. <a href="{{ route('admin.products.create') }}">Create your first product</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            
            <div class="mt-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="text-muted">
                        Showing {{ $products->firstItem() ? $products->firstItem() : 0 }} to {{ $products->lastItem() }} of {{ $products->total() }} results
                    </div>
                    <div>
                        Showing 
                        <select class="d-inline-block w-auto form-select form-select-sm ms-1 me-1" onchange="window.location='?perPage='+this.value">
                            <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                        per page
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $products->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
