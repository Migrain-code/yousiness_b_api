<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class Business extends Authenticatable
{
    use HasFactory,HasApiTokens, Notifiable;

    protected $guarded = ['business'];
    //protected $dates=['start_time', 'end_time'];
    public function package()
    {
        return $this->hasOne(BussinessPackage::class, 'id', 'package_id');
    }

    public function category()
    {
        return $this->hasOne(BusinessCategory::class, 'id', 'category_id');
    }
    public function type()
    {
        return $this->hasOne(BusinnessType::class, 'id', 'type_id');
    }

    public function workTimes()
    {
        return $this->hasMany(BusinessWorkTime::class, 'business_id', 'id')->orderBy('que');
    }

    public function services()
    {
        return $this->hasMany(BusinessService::class, 'business_id', 'id');

    }

    public function personel()
    {
        return $this->hasMany(Personel::class, 'business_id', 'id')->withDefault([
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
        return $this->hasMany(BusinessService::class, 'business_id', 'id');
    }

    public function gallery()
    {
        return $this->hasMany(BusinessGallery::class, 'business_id', 'id');
    }

    public function sales()
    {
        return $this->hasMany(ProductSales::class, 'business_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'business_id', 'id');
    }

    public function packages()
    {
        return $this->hasMany(PackageSale::class, 'business_id', 'id');
    }

    public function customers()
    {
        return $this->hasMany(BusinessCustomer::class, 'business_id', 'id');
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'business_id', 'id')->orderBy('date', 'desc');
    }

    public function cities()
    {
        return $this->hasOne(City::class, 'id', 'city');
    }

    public function districts()
    {
        return $this->hasOne(District::class, 'id', 'district');

    }

    public function notes()
    {
        return $this->hasMany(BusinessNote::class, 'business_id', 'id');
    }

    public function categories()
    {
        return $this->hasMany(BusinessTypeCategory::class, 'business_id', 'id');
    }

    public function supports()
    {
        return $this->hasMany(Support::class, 'business_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(BusinessComment::class, 'business_id', 'id')->latest();
    }

    public function offDays()
    {
        return $this->hasOne(DayList::class, 'id', 'off_day')->latest();
    }

    public function notificationsMenu()
    {
        return $this->hasMany(BusinessNotification::class, 'business_id', 'id')->where('is_status', 0)->take(5)->latest();
    }
    public function notifications()
    {
        return $this->hasMany(BusinessNotification::class, 'business_id', 'id')->latest();
    }
}
