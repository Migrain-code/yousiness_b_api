<?php

namespace App\Http\Controllers\Api\Personel;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentPersonalResource;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * @group PersonalHome
 *
 */
class HomeController extends Controller
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
        $personal = $request->user();
        $tarih = Carbon::parse($request->input('date'))->format('d.m.Y');

        $todayAppointments = $personal->appointments()->where('start_time', 'LIKE', $tarih.'%')->latest()->get();

        $earning = 0;
        $appointments = $personal->appointments()->get();
        foreach ($appointments as $row) {
            $earning += $row->service->price;
        }
        $businessServices = $personal->appointments->map(function ($appointment) {
            return $appointment->service;
        })->flatten();
        $totalTime = $this->appointmentTotalTime($businessServices);

        $businessDetailData = [
            [
                'id' => 0,
                'name' => 'Bugünkü Randevular',
                'count' => $todayAppointments->count(),
                'iconName' => 'calendar-outline',
            ],
            [
                'id' => 1,
                'name' => 'Toplam Randevu',
                'count' => $appointments->count(),
                'iconName' => 'newspaper-outline',
            ],
            [
                'id' => 2,
                'name' => 'Paket Satış Adedi',
                'count' =>  $personal->packageSales->count(),
                'iconName' => 'analytics',
            ],
            [
                'id' => 3,
                'name' => 'Ürün Satış Adedi',
                'count' => $personal->productSales->count(),
                'iconName' => 'cube-outline',
            ],
            [
                'id' => 4,
                'name' => 'Toplam Kasa Tutarı',
                'count' => $earning + $personal->packageSales->sum('total') + $personal->productSales->sum('total'),
                'iconName' => 'analytics',
            ],
            [
                'id' => 5,
                'name' => 'Toplam Randevu Süresi',
                'count' => $totalTime ." min",
                'iconName' => 'person-outline',
            ],
        ];

        return response()->json([
            'businessDetailData' => $businessDetailData,
            'today_appointments' => AppointmentPersonalResource::collection($todayAppointments),
        ]);
    }

    function appointmentTotalTime($businessServices)
    {
        $totalTime = $businessServices->reduce(function ($total, $businessService) {
            return $total + $businessService->price;
        }, 0);
        return $totalTime;
    }
}
