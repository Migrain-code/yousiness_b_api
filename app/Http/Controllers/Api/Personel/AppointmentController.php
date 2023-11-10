<?php

namespace App\Http\Controllers\Api\Personel;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentDetailResoruce;
use App\Http\Resources\AppointmentPersonalResource;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use App\Models\AppointmentServices;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * @group PersonalAppointment
 *
 */
class AppointmentController extends Controller
{
    /**
     * POST api/personal/appointment
     *
     *
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     * <li> date | required | date | tarih örnek veri 2023-11-03 </li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function index(Request $request)
    {
        $personal = $request->user();
        $tarih = Carbon::parse($request->input('date'))->format('d.m.Y');

        $appointments = $personal->appointments()->where('start_time', 'LIKE', $tarih.'%')->latest()->get();

        return response()->json([
            'appointments' => AppointmentPersonalResource::collection($appointments),
        ]);
    }
    /**
     * POST api/personal/appointment/detail
     *
     *
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     * <li> appointment_id | numeric | randevu id si</li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function detail(Request $request)
    {
        $personel = $request->user();
        $appointment = $personel->business->appointments()->where('id', $request->appointment_id)
            ->first();

        return response()->json([
            'appointment' => AppointmentDetailResoruce::make($appointment),
        ]);
    }
    /**
     * POST api/personal/appointment/cancel
     *
     *
     * <br> Gerekli alanlar
     * <ul>
     * <li> token </li>
     * <li> appointment_id | numeric | randevu id si</li>
     *</ul>
     * @header Bearer {token}
     *
     */
    public function cancel(Request $request)
    {
        $personel = $request->user();
        $appointment = $personel->business->appointments()->where('id', $request->appointment_id)
            ->first();
        if ($appointment){
            $appointment->status = 8;
            $appointment->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Randevu İptal Edildi'
            ]);
        }

        return response()->json([
            'status' => 'warning',
            'message' => 'Randevu Bulunamadı'
        ]);
    }
}

