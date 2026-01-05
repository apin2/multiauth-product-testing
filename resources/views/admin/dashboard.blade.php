@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="card shadow-sm" style="border-radius: 10px;">
            <div class="card-body text-center p-4">
                <div class="mb-3">
                    <i class="bi bi-people text-primary" style="font-size: 3rem;"></i>
                </div>
                <h5 class="card-title mb-2">Total Customers</h5>
                <div class="display-5 fw-bold text-primary mb-2">
                    {{ $totalCustomers }}
                </div>
                <p class="card-text text-muted small">
                    Registered customers in the system
                </p>
                <a href="{{ route('admin.customers.index') }}" class="btn btn-primary btn-sm mt-2">
                    View Details
                </a>
            </div>
        </div>
    </div>
</div>
@endsection