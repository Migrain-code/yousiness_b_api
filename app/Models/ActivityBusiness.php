<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityBusiness extends Model
{
    use HasFactory;

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
}
