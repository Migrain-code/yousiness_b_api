<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class AppointmentResource extends JsonResource
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
          'clock' => Carbon::parse($this->services->first()->start_time)->format('H:i'),
          'clock_range' => Carbon::parse($this->services->first()->start_time)->format('H:i')."-".Carbon::parse($this->services->first()->end_time)->format('H:i'),
          'customer' => $this->customer->name,
          'service' => $this->services->first()->service->subCategory->name,
        ];
    }
}
