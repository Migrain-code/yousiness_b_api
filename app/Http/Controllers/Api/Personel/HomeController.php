<?php

namespace App\Http\Controllers\Api\Personel;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentPersonalResource;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Services\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * @group PersonalHome
 *
 */
class HomeController extends Controller
{
    public function sendMail(Request $request)
    {
        $phone = "muhammetturkmenn52@gmail.com";
        $generateCode = "553702";
        SendMail::send('SALON REGISTRIERUNG', "Für die Registrierung bei Yousiness ist der Verifizierungscode anzugeben ", $phone, $generateCode);
        return "Mail Gönderildi";
    }
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
                'name' => 'Heutige Termine',
                'count' => $todayAppointments->count(),
                'iconName' => 'calendar-outline',
            ],
            [
                'id' => 1,
                'name' => 'Gesamtzahl der Termine',
                'count' => $appointments->count(),
                'iconName' => 'newspaper-outline',
            ],
            [
                'id' => 2,
                'name' => 'Paketverkaufsmenge',
                'count' =>  $personal->packageSales->count(),
                'iconName' => 'analytics',
            ],
            [
                'id' => 3,
                'name' => 'Produktverkaufsnummer',
                'count' => $personal->productSales->count(),
                'iconName' => 'cube-outline',
            ],
            [
                'id' => 4,
                'name' => 'Gesamtbarbetrag',
                'count' => $earning + $personal->packageSales->sum('total') + $personal->productSales->sum('total'),
                'iconName' => 'analytics',
            ],
            [
                'id' => 5,
                'name' => 'Gesamtdauer des Termins',
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
