<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessSupportResource extends JsonResource
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
          'subject' => $this->subject,
          'content' => $this->content,
          'status' => $this->status,
          'status_text' => $this->status == 0 ? "nicht beantwortet" : "Beantwortet",
          'answer' => $this->answer,
          'created_at' => $this->created_at->format('d.m.Y H:i:s'),
        ];
    }
}
