<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfficialPaymentRequest;
use App\Http\Resources\BusinessPackageResource;
//use App\Http\Resources\OfficialCardResource;
use Illuminate\Support\Facades\Session;
use Stripe\Charge;
use Stripe\Customer;
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
        $amount = 5;//5 eur
        $user = $request->user();
        $package = "Test Paketi";
        Stripe::setApiKey('sk_test_51NvSDhIHb2EidFuBWjFrNdghtNgToZOLbvopsjlNHfeiyNqw3hcZVNJo96iLJJXFhnJizZ5UXxVn8gLA7Kj268bI00vqpbTIOx');
        $customer = Customer::create(array(
            "address" => [
                "line1" => $user->address,
                "postal_code" => $user->cities->post_code,
                "city" => $user->cities->name,
                "country" => $user->cities->country->name,
            ],
            "email" => $user->owner_email,
            "name" => $user->owner,
            "source" => $request->stripeToken
        ));
        Charge::create ([
            "amount" => $amount * 100,
            "currency" => "EUR",
            "customer" => $customer->id,
            "description" => $package,
            "shipping" => [
                "name" => $user->name,
                "address" => [
                    "line1" => $user->address,
                    "postal_code" => $user->cities->post_code,
                    "city" => $user->cities->name,
                    "country" => $user->cities->country->name,
                ],
            ]
        ]);
        return response()->json([
           'status' => "success",
           'message' => "Ödeme Başarılı"
        ]);
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
