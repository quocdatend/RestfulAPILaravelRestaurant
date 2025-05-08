<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;

/**
 * Class StripePaymentService.
 */
class StripePaymentService
{
    protected $stripe;

    public function __construct()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }
    /**
     * Create a new customer and charge them.
     */
    public function createCharge($email, $token, $amount, $currency)
    { {
            try {
                // Create a new customer
                $customer = Customer::create([
                    'email' => $email,
                    'source' => $token,
                ]);

                // Charge the customer
                $charge = Charge::create([
                    'customer' => $customer->id,
                    'amount' => $amount,
                    'currency' => $currency,
                ]);

                return $charge;
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }
    }
}
