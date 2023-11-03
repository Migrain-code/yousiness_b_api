<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfficialPaymentRequest;
use App\Http\Resources\BusinessPackageResource;
//use App\Http\Resources\OfficialCardResource;
use App\Models\BussinessPackage;
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
     * <li>package_id | numeric |required | tıklanan paketin id si</li>
     * </ul>
     *
     *
     *
     *
     */
    public function createPaymentIntent(Request $request)
    {
        $package = BussinessPackage::find($request->package_id);
        $business = $request->user();
        if ($package->price == 0){
            $business->is_setup = 1;
            $business->save();
            return response()->json([
               'status' => "success",
            ]);
        }
        else{
            return response()->json([
                'status' => "warning",
                'message' => "Ödeme Yapmanız gerekiyor"
            ]);
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
