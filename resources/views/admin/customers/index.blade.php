@extends('admin.layouts.app')

@section('title', 'Customers Management')

@section('content')
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">Customers</h2>
            <p class="text-muted mb-0">Manage your customer base</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.customers.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Add Customer
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Search Section -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <form method="GET" action="{{ route('admin.customers.index') }}" class="d-flex">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Search customers..." value="{{ request('search') }}">
                            @if(request('perPage'))
                                <input type="hidden" name="perPage" value="{{ request('perPage') }}">
                            @endif
                        </div>
                        <button type="submit" class="btn btn-outline-secondary ms-2">Search</button>
                        <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary ms-2">Clear</a>
                    </form>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>S.No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Online Status</th>
                            <th>Member Since</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                            <tr>
                                <td>{{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <div class="fw-semibold">{{ $customer->name }}</div>
                                            <small class="text-muted">ID: {{ $customer->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $customer->email }}</td>
                                <td>
                                    @if($customer->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="me-2" id="status-indicator-{{ $customer->id }}">
                                            @if($customer->is_online)
                                                <i class="fas fa-circle text-success" title="Online"></i>
                                            @else
                                                <i class="fas fa-circle text-secondary" title="Offline"></i>
                                            @endif
                                        </span>
                                        <span id="status-text-{{ $customer->id }}">
                                            {{ $customer->is_online ? 'Online' : 'Offline' }}
                                        </span>
                                    </div>
                                </td>
                                <td>{{ $customer->created_at->format('M d, Y') }}</td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.customers.show', $customer->id) }}" class="btn btn-sm btn-outline-info" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.customers.edit', $customer->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.customers.toggle-status', $customer->id) }}" class="d-inline toggle-status-form" onsubmit="return confirmToggle(this, {{ $customer->id }})">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-outline-{{ $customer->is_active ? 'warning' : 'success' }}" data-customer-id="{{ $customer->id }}" data-current-status="{{ $customer->is_active ? 'active' : 'inactive' }}" title="{{ $customer->is_active ? 'Deactivate' : 'Activate' }}">
                                                @if($customer->is_active)
                                                    <i class="bi bi-x-circle" title="Deactivate"></i>
                                                @else
                                                    <i class="bi bi-check-circle" title="Activate"></i>
                                                @endif
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                                    No customers found. <a href="{{ route('admin.customers.create') }}">Create your first customer</a>.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            
            <div class="mt-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="text-muted">
                        Showing {{ $customers->firstItem() ? $customers->firstItem() : 0 }} to {{ $customers->lastItem() }} of {{ $customers->total() }} results
                    </div>
                    <div>
                        Showing 
                        <select class="d-inline-block w-auto form-select form-select-sm ms-1 me-1" onchange="window.location='?perPage='+this.value+'&search='+encodeURIComponent('{{ request('search') }}')">
                            <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                        per page
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $customers->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <script>
        // Function to update customer status indicators
        function updateCustomerStatuses() {
            fetch('{{ route("admin.customers.status") }}')
                .then(response => response.json())
                .then(data => {
                    data.customers.forEach(customer => {
                        const statusIndicator = document.getElementById(`status-indicator-${customer.id}`);
                        const statusText = document.getElementById(`status-text-${customer.id}`);
                        
                        if (statusIndicator && statusText) {
                            if (customer.is_online) {
                                statusIndicator.innerHTML = '<i class="fas fa-circle text-success" title="Online"></i>';
                                statusText.textContent = 'Online';
                            } else {
                                statusIndicator.innerHTML = '<i class="fas fa-circle text-secondary" title="Offline"></i>';
                                statusText.textContent = 'Offline';
                            }
                        }
                    });
                })
                .catch(error => console.error('Error fetching customer statuses:', error));
        }
        
        // Update customer statuses every 5 seconds
        setInterval(updateCustomerStatuses, 5000);
        
        // Initial update
        updateCustomerStatuses();
    </script>
@endsection