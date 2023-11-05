<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
/**
 * @group BusinessHome
 *
 */
class BusinessHomeController extends Controller
{
    /**
     * POST api/business-service/update
     *
     * bu apiden sonra size randevu sayısı, müşteri sayısı, personel sayısı, toplam randevu tutarı, ürün satış sayısı, toplam kasa tutarı ve bugünkü randevular döndürülecek
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function index(Request $request)
    {
        $business = $request->user();
        $todayAppointments = Appointment::where('business_id', auth('business')->id())
            ->where('status', 1)
            ->where('date', $request->input('date'))
            ->get();

        $earning = 0;
        $appointments = $business->appointments()->get();
        foreach ($appointments as $row) {
            $earning += calculateTotal($row->services);
        }
        $businessDetailData = [
            [
                'id' => 0,
                'name' => 'Randevu Sayısı',
                'count' => $appointments->count(),
                'iconName' => 'calendar-outline',
            ],

        ];

        return response()->json([
            'businessDetailData' => $businessDetailData,
            'today_appointments' => AppointmentResource::collection($todayAppointments),
        ]);
    }
}
