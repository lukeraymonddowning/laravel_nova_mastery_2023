<?php

namespace App\Services\DiscountService;

use App\Models\Customer;

class DiscountService
{
    public function email(Customer $user, int $discount): void
    {
        /**
         * Welcome, fellow source code reader! You caught me faking a slow email service.
         * I can only apologise for the complete lack of trust this must engendered in you.
         */

        ray('Sending discount email to ' . $user->email . ' with ' . $discount . '% discount…');
        sleep(3);
        ray('Discount email sent!');
    }
}
