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
          'status_text' => $this->status == 0 ? "Cevaplanmadı" : "Cevaplandı",
          'answer' => $this->answer,
        ];
    }
}
