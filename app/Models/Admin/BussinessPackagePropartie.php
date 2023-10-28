<?php

namespace App\Models\Admin;

use App\Models\BussinessPackagePropartieList;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BussinessPackagePropartie extends Model
{
    use HasFactory;

    public function list()
    {
        return $this->hasOne(BussinessPackagePropartieList::class, 'id', 'propartie_id');
    }

    public function package()
    {
        return $this->hasOne(BussinessPackage::class, 'id', 'package_id');
    }
}
