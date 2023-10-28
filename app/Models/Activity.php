<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $dates=['start_date', 'stop_date'];

    public function personels()
    {
        return $this->hasMany(ActivityBusiness::class, 'activity_id', 'id');
    }
    public function sponsors()
    {
        return $this->hasMany(ActivitySponsor::class, 'activity_id', 'id')->latest();
    }
    public function sliders()
    {
        return $this->hasMany(ActivitySlider::class, 'activity_id', 'id')->latest();
    }

    public function images()
    {
        return $this->hasMany(ActivityImages::class, 'activity_id', 'id')->latest();
    }

    public function citys()
    {
        return $this->hasOne(City::class, 'id', 'city');
    }
}
