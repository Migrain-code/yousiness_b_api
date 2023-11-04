<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class AppointmentDetailResoruce extends JsonResource
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
            'date' => Carbon::parse($this->date)->format('d.m.Y'),
            'status' => $this->status("text"),
            'comment_status' => $this->comment_status,
            'services' => AppointmentServiceResource::collection($this->services),
            'customer' => BusinessCustomerResource::make($this->customer),
        ];
    }
}
