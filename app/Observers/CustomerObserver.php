<?php

namespace App\Observers;

use App\Events\CustomerStatusUpdated;
use App\Models\Customer;

class CustomerObserver
{
    public function updated(Customer $customer)
    {
        // Check if the is_online field was changed
        if ($customer->isDirty('is_online')) {
            event(new CustomerStatusUpdated($customer));
        }
    }
}