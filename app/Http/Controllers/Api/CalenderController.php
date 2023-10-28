<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Business;
use App\Services\GoogleCalender;
use Illuminate\Http\Request;

class CalenderController extends Controller
{
    public function getEvents(Request $request,$businessKey)
    {
        $business = Business::where('key', $businessKey)->first();
        if ($business) {

            $appointments = $business->appointments; // Etkinlik verilerini veritabanından alın (örnek olarak tüm randevuları aldık)

            $events = [];
            foreach ($appointments as $appointment) {
                $event = [
                    'title' => $appointment->customer->name,
                    'start' => $appointment->start_time->toIso8601String(),
                    'end' => $appointment->end_time->toIso8601String(),
                    'customer' => 'Muhammet Türkmen', // Sabit bir müşteri adı veya farklı bir kaynaktan alınabilir
                    'clockRange' => $appointment->start_time->format('H:i') . '-' . $appointment->end_time->format('H:i'),
                    'statusText' => $appointment->status('text'),
                    'statusCode' => $appointment->status('code'),
                    'services' => [],
                ];

                foreach ($appointment->services as $service) {
                    $event['services'][] = [
                        'image' => asset('storage/' . $service->personel->image), // Eğer resimler storage klasöründe ise
                        'personel' => $service->personel->name,
                        'hizmet' => $service->service->subCategory->name,
                    ];
                }

                $events[] = $event;
            }
            return response()->json($events);
        } else {
            return response()->json([
                'status' => "error",
                'message' => "İşletme kaydı bulunamadı"
            ], 404);
        }
    }

    public function exportGoogle()
    {
        $apiKey = 'AIzaSyAESuQeot_Y76HEPqe1sx8vf2pgzfpuDVQ'; // Google Takvim API için API anahtarı
        $googleCalendar = new GoogleCalender($apiKey);

        $calendarId = 'primary'; // Takvim ID'si, varsayılan takvim için 'primary' kullanabilirsiniz.

        $eventData = [
            'summary' => 'Etkinlik Başlığı',
            'description' => 'Etkinlik Açıklaması',
            'start' => [
                'dateTime' => '2023-09-15T10:00:00',
                'timeZone' => 'Europe/Istanbul',
            ],
            'end' => [
                'dateTime' => '2023-09-15T12:00:00',
                'timeZone' => 'Europe/Istanbul',
            ],
        ];

        $response = $googleCalendar->createEvent($calendarId, $eventData);

        if ($response !== false) {
            return back()->with('response', [
                'status' => "success",
                'message' => "Takvime Eklendi",
            ]);
        } else {
            return back()->with('response', [
                'status' => "danger",
                'message' => "Hata",
            ]);
        }

    }
}
