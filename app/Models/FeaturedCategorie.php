<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeaturedCategorie extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->hasOne(BusinessCategory::class, 'id', 'category_id');
    }

    public function cities()
    {
        return $this->hasMany(FeaturedCategoryCity::class, 'featured_id', 'id');
    }
}
