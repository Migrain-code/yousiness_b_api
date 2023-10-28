<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfficialPaymentRequest;
use App\Http\Resources\BusinessPackageResource;
use App\Http\Resources\OfficialCardResource;
use Illuminate\Http\Request;
/**
 * @group Payment
 *
 */

class PaymentController extends Controller
{
    /**
     * GET api/payment
     *
     *
     * <ul>
     * <li>Bearer Token | string | required | Kullanıcı Token</li>
     * </ul>
     * Kullanıcını işletmesinin packet bilgisi ve kullanıcının cartları
     *
     *
     *
     */
    public function index(Request $request)
    {
        $business = $request->user();

        return response()->json([
           'packet' => BusinessPackageResource::make($business->package),
        ]);
    }
    /**
     * POST api/payment/pay
     *
     *
     * <ul>
     * <li>Bearer Token | string | required | Kullanıcı Token</li>
     * <li>cart_id | numeric | required | Seçilen Kart Bilgisi</li>
     * </ul>
     * Kullanıcını işletmesinin packet bilgisi ve kullanıcının cartları
     *
     *
     *
     */
    public function pay(OfficialPaymentRequest $request)
    {
        $business = $request->user();

        return response()->json([
            'status' => "success",
            'message' => "Ödeme İşleminiz Tamamlandı"
        ]);
    }
}
