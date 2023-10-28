<?php

namespace App\Models;

use App\Models\BussinessPackagePropartie;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BussinessPackage extends Model
{
    use HasFactory;
    public function proparties()
    {
        return $this->hasMany(BussinessPackagePropartie::class, 'package_id', 'id');
    }
}
