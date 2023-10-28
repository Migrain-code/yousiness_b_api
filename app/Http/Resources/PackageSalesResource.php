<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageSalesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
          'id'=> $this->id,
          'customer_name' => $this->customer->name,
          'seller_date' => $this->seller_date->format('d.m.y H:i:s'),
          'personal' => $this->personel->name,
          'type' => $this->type == 0 ? "Seans" : "Dakika",
          'amount' => $this->amount,
          'total' => $this->total,
        ];
    }
}
