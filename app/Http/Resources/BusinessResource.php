<?php

namespace App\Http\Resources;

use App\Models\City;
use App\Models\District;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
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
           'name' => $this->name,
           'logo' => asset($this->logo),
           'wallpaper' => asset($this->wallpaper),
           'city' => new CityResource($this->cities),
           'category' => BusinessCategoryResource::collection($this->categories),
           'start_time' => $this->start_time,
           'end_time' => $this->end_time,
           'is_main' => $this->is_main == 1 ? "Ana İşletme" : "Alt İşletme",
           'packet' => new BusinessPackageResource($this->package),
           'packet_end_date' => $this->packet_end_date,
           'packet_start_date' => $this->packet_start_date,
           'appointment_range' => $this->appoinment_range,
           'type' => $this->type,
           'about' => $this->about,
           'embed' => $this->embed,
           'address' => $this->address,
           'setup' => $this->setup_status,
        ];
    }
}
