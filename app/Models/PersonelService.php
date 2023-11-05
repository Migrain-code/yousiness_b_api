<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonelService extends Model
{
    use HasFactory;

    public function service()
    {
        return $this->hasOne(BusinessService::class, 'id', 'service_id');
    }
    public function personel(){
        return $this->hasOne(Personel::class,'id', 'personel_id')->withDefault([
            'name' => "Silinmiş Personel",
            'image' => "Silinmiş Personel",
            'email' => "Silinmiş Personel",
            'phone' => "Silinmiş Personel",
            'start_time' => "Silinmiş Personel",
            'end_time' => "Silinmiş Personel",
        ]);
    }
}
