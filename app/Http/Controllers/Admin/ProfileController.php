<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $admin = auth()->guard('admin')->user();
        return view('admin.profile.show', compact('admin'));
    }
    
    public function edit()
    {
        $admin = auth()->guard('admin')->user();
        return view('admin.profile.edit', compact('admin'));
    }
    
    public function update(Request $request)
    {
        $admin = auth()->guard('admin')->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
        ]);
        
        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        
        return redirect()->route('admin.profile.index')->with('success', 'Profile updated successfully!');
    }
    
    public function editPassword()
    {
        $admin = auth()->guard('admin')->user();
        return view('admin.profile.password', compact('admin'));
    }
    
    public function updatePassword(Request $request)
    {
        $admin = auth()->guard('admin')->user();
        
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);
        
        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }
        
        $admin->update([
            'password' => Hash::make($request->new_password),
        ]);
        
        return redirect()->route('admin.profile.index')->with('success', 'Password updated successfully!');
    }
}