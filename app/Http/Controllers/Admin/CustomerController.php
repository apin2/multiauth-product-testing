<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Event;
use App\Events\CustomerStatusUpdated;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();
        
        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        
        // Get perPage value from request with validation
        $allowedPerPage = [10, 25, 50, 100];
        $perPage = in_array($request->get('perPage'), $allowedPerPage) ? $request->get('perPage') : 10;
        
        $customers = $query->paginate($perPage)->appends(request()->query());
        
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'password' => 'required|min:6|confirmed',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $isActive = $request->has('is_active') ? $request->is_active : true;
        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => $isActive,
            'is_online' => false, // New customers are not online initially
        ]);
        
        // Broadcast the status update
        event(new \App\Events\CustomerStatusUpdated($customer));

        return redirect()->route('admin.customers.index')->with('success', 'Customer created successfully');
    }

    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customers.show', compact('customer'));
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        
        // Handle is_active field separately to manage online status
        if ($request->has('is_active')) {
            $newActiveStatus = $request->is_active;
            $data['is_active'] = $newActiveStatus;
            
            // If deactivating the customer, also set them as offline
            if (!$newActiveStatus && $customer->is_online) {
                $data['is_online'] = false;
            }
        }
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $customer->update($data);
        
        // Check if is_online status changed and broadcast if needed
        if ($customer->isDirty('is_online')) {
            event(new \App\Events\CustomerStatusUpdated($customer));
        }

        return redirect()->route('admin.customers.index')->with('success', 'Customer updated successfully');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        
        // Broadcast the status update before deletion
        event(new \App\Events\CustomerStatusUpdated($customer));
        
        $customer->delete();

        return redirect()->route('admin.customers.index')->with('success', 'Customer deleted successfully');
    }

    public function updateStatus(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'is_active' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
        
        // If deactivating the customer, also set them as offline
        $newActiveStatus = $request->is_active;
        $updateData = ['is_active' => $newActiveStatus];
        
        if (!$newActiveStatus && $customer->is_online) {
            $updateData['is_online'] = false;
        }
        
        $customer->update($updateData);
        
        // Broadcast the status update
        event(new \App\Events\CustomerStatusUpdated($customer));

        return response()->json([
            'message' => 'Customer status updated successfully',
            'customer' => $customer
        ]);
    }

    public function toggleStatus($id)
    {
        $customer = Customer::findOrFail($id);
        
        // If deactivating the customer, also set them as offline
        $newActiveStatus = !$customer->is_active;
        $updateData = ['is_active' => $newActiveStatus];
        
        if (!$newActiveStatus && $customer->is_online) {
            $updateData['is_online'] = false;
        }
        
        $customer->update($updateData);
        
        // Broadcast the status update
        event(new \App\Events\CustomerStatusUpdated($customer));

        return redirect()->route('admin.customers.index')->with('success', 'Customer status updated successfully');
    }

    public function getStatus()
    {
        $customers = Customer::select('id', 'is_online', 'is_active')->get();
        
        return response()->json([
            'customers' => $customers
        ]);
    }
}