@extends('admin.layouts.app')

@section('title', 'Import Products')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Import Products</h2>
    </div>
    
    <div class="card">
        <div class="card-body">
            <p class="text-muted">Upload a CSV or Excel file to import products. The file should have the following columns in order: name, description, price, image, category, stock.</p>
            
            <form method="POST" enctype="multipart/form-data" action="{{ route('admin.products.import.store') }}">
                @csrf
                
                <div class="mb-3 w-50">
                    <label for="file" class="form-label">CSV File</label>
                    <input type="file" name="file" id="file" class="form-control" accept=".csv,.xlsx,.xls" required>
                    <div class="form-text">Supported formats: CSV, XLS, XLSX</div>
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-upload me-1"></i>Import Products
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection