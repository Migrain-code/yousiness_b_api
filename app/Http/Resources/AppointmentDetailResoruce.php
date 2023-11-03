<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'business' => BusinessResource::make($this->business),
            'date' => $this->start_time,
            'status' => $this->status("text"),
            'comment_status' => $this->comment_status,
            'services' => AppointmentServiceResource::collection($this->services),
        ];
    }
}
