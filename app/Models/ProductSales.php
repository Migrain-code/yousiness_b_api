<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSales extends Model
{
    use HasFactory;

    const PAYMENT_TYPES = [
        0 => 'Nakit Ödeme',
        1 => 'Banka/Kredi Kartı',
        2 => 'EFT/Havale',
        3 => 'Diğer',
    ];

    public function customer()
    {
        return $this->hasOne(Customer::class,'id', 'customer_id')->withDefault([
            'name' => "Silinmiş Müşteri",
            'image' => "Silinmiş Müşteri",
            'custom_email' => "Silinmiş Müşteri",
            'phone' => "Silinmiş Müşteri",
            'created_at' => Carbon::now(),
            'email' => "Silinmiş Müşteri",
            'status' => "Silinmiş Müşteri",
        ]);
    }

    public function personel()
    {
        return $this->hasOne(Personel::class,'id', 'personel_id');
    }
    public function product()
    {
        return $this->hasOne(Product::class,'id', 'product_id');
    }

    public function paymentType()
    {
        return self::PAYMENT_TYPES[$this->payment_type];
    }
}
