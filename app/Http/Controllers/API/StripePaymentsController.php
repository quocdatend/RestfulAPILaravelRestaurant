<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\StripePaymentService;
use App\Http\Requests\StripePaymentRequest;

class StripePaymentsController extends Controller
{
    protected $stripePaymentService;

    public function __construct(StripePaymentService $stripePaymentService)
    {
        $this->stripePaymentService = $stripePaymentService;
    }

    public function index()
    {
        // json
        return response()->json([
            'message' => 'Stripe Payments API',
            'status' => 200
        ]);
    }

    public function payment(StripePaymentRequest $request)
    {
        $validated = $request->validated();

        $charge = $this->stripePaymentService->createCharge(
            $validated['email'],
            $validated['token'],
            $validated['amount'],
            $validated['currency']
        );

        if ($charge) {
            return response()->json([
                'message' => 'Payment Successful',
                'status' => 200,
                'data' => $charge
            ]);
        } else {
            return response()->json([
                'message' => 'Payment Failed',
                'status' => 500
            ]);
        }
    }

    public function complete()
    {
        // json
        return response()->json([
            'message' => 'Payment Completed',
            'status' => 200
        ]);
    }
}
