<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityBusiness extends Model
{
    use HasFactory;

    public function personel()
    {
        return $this->hasOne(Personel::class, 'id', 'personel_id');
    }
}
