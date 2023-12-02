<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonelResource extends JsonResource
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
          'image' => storage($this->image),
          'email' => $this->email,
          'phone' => $this->phone,
          'approve_type' => $this->accepted_type == 0 ? "Manuel Bestätigung" : "Automatische Bestätigung",
          'rest_day' => $this->rest_day,
          'start_time' => $this->start_time,
          'end_time' => $this->end_time,
          'food_start' => $this->food_start,
          'food_end' => $this->food_end,
          'gender' => $this->type->name ?? "",
          'rate' => $this->rate,
          'appointment_range' => $this->range,
          'accept' => $this->accept == 1 ? "Ja" : "Nein",
          'description' => $this->description,
          'business_name' => $this->business->name,
          'user_type' => 0,
        ];
    }
}
