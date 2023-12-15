<?php

namespace App\Models;

use App\Services\Sms;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;

class Customer extends Authenticatable
{
    use HasFactory;
    protected $guarded = [];

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'customer_id', 'id');
    }
    public function businessAppointments($businessId)
    {
        return Appointment::where('customer_id', $this->id)->where('business_id', $businessId)->get();
    }

    public function daysLeft()
    {
        $birthdate = Carbon::parse($this->birthday);
        $now = Carbon::now();
        $birthdate->year($now->year);

        if ($birthdate->isPast()) {
            return 0;
            /*$birthdate->addYear();//bir sonraki yıla kalan süre*/
        }
        $daysLeft = $now->diffInDays($birthdate, true);

        return $daysLeft;
    }
    public function sendSms($message)
    {
        $clean_phone_number = clearPhone($this->phone);
        Sms::send($clean_phone_number, $message);
        return true;
    }

    public function permissions()
    {
        return $this->hasOne(CustomerNotificationPermission::class ,'customer_id', 'id');
    }
}
