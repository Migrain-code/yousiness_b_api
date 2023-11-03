<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductSaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
          'business' => new BusinessResource($this->business),
          'payment_type' => $this->paymentType(),
          'piece' => $this->piece,
          'total' => $this->total,
          'created_at'=> $this->created_at->format('d.m.Y H:i:s')
        ];
    }
}
