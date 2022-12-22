<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderKitchenResource extends JsonResource
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
            'id'                        => $this->id,
            'ticket_number'             => $this->ticket_number,
            'status'                    => $this->status,
            'status_label'              => $this->getStatusNameAttribute(),
            'user_id'                   => $this->customer->user_id,
            'date'                      => $this->date,
            'created_at'                => $this->created_at,
            'update_at'                 => $this->updated_at,
            'items'                     => OrderItemKitchenResource::collection($this->orderItems),
            'notes'                     => $this->notes,
        ];
    }
}
