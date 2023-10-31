<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfficialPaymentRequest;
use App\Http\Resources\BusinessPackageResource;
//use App\Http\Resources\OfficialCardResource;
use Stripe\EphemeralKey;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Illuminate\Http\Request;
/**
 * @group Payment
 *
 */

class PaymentController extends Controller
{
    /**
     * POST /create-payment-intent
     *
     *
     * <ul>
     * <li>Bearer Token | string | required | Kullanıcı Token</li>
     * </ul>
     *
     *
     *
     *
     */
    public function createPaymentIntent(Request $request)
    {
        $business = $request->user();
        try {
            Stripe::setApiKey('sk_test_51NvSDhIHb2EidFuBWjFrNdghtNgToZOLbvopsjlNHfeiyNqw3hcZVNJo96iLJJXFhnJizZ5UXxVn8gLA7Kj268bI00vqpbTIOx');
            $ephemeralKey = EphemeralKey::create(
                ['customer' => $business->id],
                ['stripe_version' => '2023-10-16']
            );
            $amount = 1000; // Ödeme miktarını ayarlayın (örnekte 10.00 dolar)
            $currency = 'EUR';

            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => $currency,
                'description' => "Yeni Paket Alım Ödemesi"
            ]);

            return response()->json([
                'paymentIntent' => $paymentIntent->client_secret,
                'ephemeralKey' => $ephemeralKey, // Ephemeral Key'i burada ayarlayın
                'customer' => $business->id,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * POST /process-payment
     *
     *
     * <ul>
     * <li>Bearer Token | string | required | Kullanıcı Token</li>
     * </ul>
     *
     *
     *
     *
     */
    public function processPayment(Request $request)
    {
        try {
            Stripe::setApiKey('sk_test_51NvSDhIHb2EidFuBWjFrNdghtNgToZOLbvopsjlNHfeiyNqw3hcZVNJo96iLJJXFhnJizZ5UXxVn8gLA7Kj268bI00vqpbTIOx');

            $paymentIntent = PaymentIntent::retrieve($request->input('payment_intent'));

            if ($paymentIntent->status === 'succeeded') {
                // Ödeme başarılı, işlemleri burada yapabilirsiniz.
                return response()->json(['message' => 'Ödeme başarılı.']);
            } else {
                return response()->json(['error' => 'Ödeme başarısız.']);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
