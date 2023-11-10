<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessCommentResource extends JsonResource
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
          'customer' => BusinessCustomerResource::make($this->customer),
          'content' => $this->content,
          'status' => $this->status,
          'point' => $this->point,
          'answer' => $this->answer,
          'date' => $this->created_at->format('d.m.Y H:i:s')
        ];
    }
}
