<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    use HasFactory;
    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id')->withDefault([
            'name' => "Silinmiş Müşteri",
            'image' => "Silinmiş Müşteri",
            'custom_email' => "Silinmiş Müşteri",
            'phone' => "Silinmiş Müşteri",
            'created_at' => Carbon::now(),
            'email' => "Silinmiş Müşteri",
            'status' => "Silinmiş Müşteri",
        ]);
    }
}
