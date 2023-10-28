<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessServiceResource extends JsonResource
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
            "id"=> $this->id,
            "type"=> $this->gender->name,
            "category"=> $this->categorys->name,
            "sub_category"=> $this->subCategory->name,
            "price"=> $this->price,
        ];
    }
}
