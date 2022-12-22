<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BoardItemsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $status = ["P" => "Preparing", "R" => "Ready", "D" => "Delivered"];
        return[
            'id'            => $this->id,
            'status'        => $this->status,
            'ticket_number' => $this->ticket_number,
            'status_label'  => $status[$this->status],
            'date'          => $this->date,
        ];
    }
}
