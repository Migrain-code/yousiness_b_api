<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Payout;
use Stripe\PaymentMethod;

class StripeService
{
    protected $stripe;

    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $this->stripe = new Stripe();
    }

    public function createPaymentIntent($amount, $currency)
    {
        try {
            $intent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => $currency,
                'payment_method_types' => ['card'],
            ]);

            return $intent;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function confirmPaymentIntent($paymentIntentId, $paymentMethod)
    {
        try {
            $intent = PaymentIntent::retrieve($paymentIntentId);
            $intent->confirm(['payment_method' => $paymentMethod]);
            return $intent;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function createPayout($amount, $currency)
    {
        try {
            $payout = Payout::create([
                'amount' => $amount,
                'currency' => $currency,
            ]);

            return $payout;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function createPaymentMethod($cardNumber, $expMonth, $expYear, $cvc)
    {
        try {
            $paymentMethod = PaymentMethod::create([
                'type' => 'card',
                'card' => [
                    'number' => $cardNumber,
                    'exp_month' => $expMonth,
                    'exp_year' => $expYear,
                    'cvc' => $cvc,
                ],
            ]);

            return $paymentMethod;
        } catch (\Exception $e) {
            return false;
        }
    }
}
