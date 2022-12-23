<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderStatusResource extends JsonResource
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
        return [
            'id'                        => $this->id,
            'status'                    => $this->status,
            'status_label'              => $status[$this->status],
            'date'                      => $this->date,
        ];
    }
}
