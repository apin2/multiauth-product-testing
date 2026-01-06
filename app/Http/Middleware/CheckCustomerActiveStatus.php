<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckCustomerActiveStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if customer is authenticated and their status has changed to inactive
        if (Auth::guard('customer')->check()) {
            $customerId = Auth::guard('customer')->id();
            $customer = \App\Models\Customer::find($customerId);
            
            // If the customer is no longer active, log them out
            if ($customer && !$customer->is_active) {
                // Set the customer as offline
                $customer->is_online = false;
                $customer->save();
                
                // Log the customer out
                Auth::guard('customer')->logout();
                
                // Redirect to login with a message
                return redirect()->route('customer.login')
                    ->with('error', 'Your account has been deactivated. Please contact the administrator.');
            }
        }
        
        return $next($request);
    }
}
