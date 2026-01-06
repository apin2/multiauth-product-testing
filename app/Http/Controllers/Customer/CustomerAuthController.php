<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerAuthController extends Controller
{
    public function showLogin()
    {
        return view('customer.auth.login');
    }

    public function showRegister()
    {
        return view('customer.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:customers',
            'password' => 'required|min:6|confirmed',
        ]);

        $customer = Customer::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => false,
        ]);

        Auth::guard('customer')->login($customer);

        return redirect()->route('customer.dashboard');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::guard('customer')->attempt($credentials, $remember)) {
            $customer = Auth::guard('customer')->user();
            
            if ($customer && !$customer->is_active) {
                Auth::guard('customer')->logout();
                return back()->withErrors(['email' => 'Your account is inactive. Please contact admin to activate your account.']);
            }
            
            if ($customer) {
                $customer->is_online = true;
                $customer->save();
            }
            
            return redirect()->route('customer.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function dashboard()
    {
        return view('customer.dashboard');
    }

    public function logout()
    {
        $customer = Auth::guard('customer')->user();
        if ($customer) {
            $customer->is_online = false;
            $customer->save();
        }
        Auth::guard('customer')->logout();

        $response = redirect('/');
        $response->headers->set('Cache-Control', 'no-cache, no-store, must-revalidate, max-age=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Thu, 01 Jan 1970 00:00:01 GMT');
        
        return $response;
    }
}