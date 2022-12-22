<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LastOrdersResource extends JsonResource
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
            'total_price'               => (float) $this->total_price,
            'total_paid'                => (float) $this->total_paid,
            'points_gained'             => $this->points_gained,
            'payment_type'              => $this->payment_type,
            'date'                      => $this->date,
            'delivered_by'              => $this->delivered_by != null ? $this->responsible->name : '',
            'created_at'                => $this->created_at,
            'update_at'                 => $this->updated_at,
            'total_items'               => (int) $this->orderItems->count()
        ];
    }
}
