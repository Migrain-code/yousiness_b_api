<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppointmentServices extends Model
{
    use HasFactory;
    public function service()
    {
        return $this->hasOne(BusinessService::class, 'id', 'service_id')->withDefault([
            'price' => 1,
        ]);
    }

    public function personel()
    {
        return $this->hasOne(Personel::class, 'id', 'personel_id')->withDefault([
            'name' => "Silinmiş Personel",
            'image' => "Silinmiş Personel",
            'email' => "Silinmiş Personel",
            'phone' => "Silinmiş Personel",
            'start_time' => "Silinmiş Personel",
            'end_time' => "Silinmiş Personel",
        ]);
    }

    public function appointment()
    {
        return $this->hasOne(Appointment::class, 'id', 'appointment_id');
    }
}
