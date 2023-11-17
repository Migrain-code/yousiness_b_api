<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentDetailResoruce;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

/**
 * @group Appointment
 *
 *
 */
class AppointmentController extends Controller
{
    /**
     * POST api/business/appointment
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
        $appointments = Appointment::where('business_id', $request->user()->id)
            ->where('status', 1)
            ->whereDate('date', Carbon::parse($request->input('date'))->format('Y-m-d H:i:s'))
            ->latest()
            ->get();

        return response()->json([
            'appointments' => AppointmentResource::collection($appointments),
        ]);
    }
    /**
     * POST api/business/appointment/detail
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
        $business = $request->user();
        $appointment = Appointment::where('business_id', $business->id)->where('id', $request->appointment_id)
            ->first();

        return response()->json([
            'appointment' => AppointmentDetailResoruce::make($appointment),
        ]);
    }
    /**
     * POST api/business/appointment/cancel
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
        $business = $request->user();
        $appointment = Appointment::where('business_id', $business->id)->where('id', $request->appointment_id)
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
