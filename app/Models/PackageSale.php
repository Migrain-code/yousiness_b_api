<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageSale extends Model
{
    use HasFactory;
    protected $dates=["seller_date"];
    public function customer()
    {
        return $this->hasOne(Customer::class,'id', 'customer_id')->withDefault([
            'name' => "Silinmiş Müşteri",
            'image' => "Silinmiş Müşteri",
            'custom_email' => "Silinmiş Müşteri",
            'phone' => "Silinmiş Müşteri",
            'created_at' => Carbon::now(),
            'email' => "Silinmiş Müşteri",
            'status' => "Silinmiş Müşteri",
        ]);
    }
    public function personel()
    {
        return $this->hasOne(Personel::class,'id', 'personel_id')->withDefault([
            'name' => "Silinmiş Personel",
            'image' => "Silinmiş Personel",
            'email' => "Silinmiş Personel",
            'phone' => "Silinmiş Personel",
            'start_time' => "Silinmiş Personel",
            'end_time' => "Silinmiş Personel",
        ]);
    }
    public function service()
    {
        return $this->hasOne(BusinessService::class,'id', 'service_id');
    }

    public function usages()
    {
        return $this->hasMany(PackageUsage::class,'package_id', 'id');
    }

    public function payeds()
    {
        return $this->hasMany(PackagePayment::class,'package_id', 'id');
    }
}
