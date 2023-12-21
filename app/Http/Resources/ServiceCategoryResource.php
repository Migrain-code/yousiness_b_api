<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceCategoryResource extends JsonResource
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
           'id' => $this->id,
           'name' => $this->name. "(". $this->type->name . ")",
           'order' => $this->order_number,
           'gender' => $this->type->name,
           'sub_categories' =>ServiceSubCategoryResource::collection($this->subCategories),
        ];
    }
}
