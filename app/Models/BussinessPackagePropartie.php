<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BussinessPackagePropartie extends Model
{
    use HasFactory;
    public function list()
    {
        return $this->hasOne(BussinessPackagePropartieList::class, 'id', 'propartie_id');
    }
}
