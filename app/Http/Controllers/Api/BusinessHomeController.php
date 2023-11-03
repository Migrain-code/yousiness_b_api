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
            ->where('date', date('Y-m-d'))
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
            [
                'id' => 1,
                'name' => 'Randevular Tutarı',
                'count' => $earning,
                'iconName' => 'newspaper-outline',
            ],
            [
                'id' => 2,
                'name' => 'Müşteri Sayısı',
                'count' =>  $business->customers->count(),
                'iconName' => 'person-outline',
            ],
            [
                'id' => 3,
                'name' => 'Ürün Satışı Sayısı',
                'count' => $business->sales->count(),
                'iconName' => 'cube-outline',
            ],
            [
                'id' => 4,
                'name' => 'Toplam Kasa Tutarı',
                'count' => $earning + $business->packages->sum('total') + $business->sales->sum('price'),
                'iconName' => 'analytics',
            ],
            [
                'id' => 5,
                'name' => 'Toplam personel Sayısı',
                'count' => $business->personel->count(),
                'iconName' => 'person-outline',
            ],
        ];

        return response()->json([
            'businessDetailData' => $businessDetailData,
            'today_appointments' => AppointmentResource::collection($todayAppointments),
        ]);
    }
}
