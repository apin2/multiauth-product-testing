<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $customer = auth()->guard('customer')->user();
        return view('customer.profile.show', compact('customer'));
    }
    
    public function edit()
    {
        $customer = auth()->guard('customer')->user();
        return view('customer.profile.edit', compact('customer'));
    }
    
    public function update(Request $request)
    {
        $customer = auth()->guard('customer')->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
        ]);
        
        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        
        return redirect()->route('customer.profile.index')->with('success', 'Profile updated successfully!');
    }
    
    public function editPassword()
    {
        $customer = auth()->guard('customer')->user();
        return view('customer.profile.password', compact('customer'));
    }
    
    public function updatePassword(Request $request)
    {
        $customer = auth()->guard('customer')->user();
        
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);
        
        if (!Hash::check($request->current_password, $customer->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }
        
        $customer->update([
            'password' => Hash::make($request->new_password),
        ]);
        
        return redirect()->route('customer.profile.index')->with('success', 'Password updated successfully!');
    }
}