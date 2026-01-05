@extends('customer.layouts.app')

@section('title', 'Customer Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Customer Dashboard</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5>Welcome to your dashboard!</h5>
                            <p class="lead">You are logged in as a customer.</p>
                            <p>Email: {{ Auth::guard('customer')->user()->email }}</p>
                            <p>Status: <span class="badge bg-success">Online</span></p>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="bi bi-person-circle" style="font-size: 3rem;"></i>
                                    <h5 class="card-title">{{ Auth::guard('customer')->user()->name }}</h5>
                                    <p class="card-text">Customer Account</p>
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