<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BusinessHomeController extends Controller
{
    public function index(Request $request)
    {
        $business = $request->user();
        $todayAppointments = Appointment::where('business_id', auth('business')->id())
            ->where('status', 1)
            ->whereRaw("STR_TO_DATE(date, '%d.%m.%Y') = ?", [Carbon::now()->format('Y-m-d')])
            ->orderByRaw("STR_TO_DATE(date, '%d.%m.%Y')")
            ->get();
        $earning = 0;
        $appointments = $business->appointments()->get();
        foreach ($appointments as $row) {
            $earning += calculateTotal($row->services);
        }
        return response()->json([
            'appointments_count' => $appointments->count(),
            'customer_count' => $business->customers->count(),
            'personel_count' => $business->personel->count(),
            'appointment_total_price' => $earning,
            'today_appointments' => $todayAppointments,
            'product_sale_count' => $business->sales->count(),
        ]);
    }
}
