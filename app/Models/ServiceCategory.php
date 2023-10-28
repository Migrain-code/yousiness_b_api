<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use HasFactory;
    protected $fillable=['type_id', 'name'];
    public function subCategories()
    {
        return $this->hasMany(ServiceSubCategory::class,'category_id', 'id');
    }

    public function type()
    {
        return $this->hasOne(BusinnessType::class, 'id', 'type_id');
    }
}
