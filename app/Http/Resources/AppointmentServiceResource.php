<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentServiceResource extends JsonResource
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
          'personel' => PersonelResource::make($this->personel),
          'name' => $this->service->subCategory->name,
          'start_time' => $this->start_time,
          'end_time' => $this->end_time,
        ];
    }
}
