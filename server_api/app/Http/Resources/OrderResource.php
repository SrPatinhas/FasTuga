<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'customer'                  => new CustomerResource($this->customer),
            'total_price'               => (float) $this->total_price,
            'total_paid'                => (float) $this->total_paid,
            'total_paid_with_points'    => (float) $this->total_paid_with_points,
            'points_gained'             => (int) $this->points_gained,
            'points_used_to_pay'        => (int) $this->points_used_to_pay,
            'payment_type'              => $this->payment_type,
            'payment_reference'         => $this->payment_reference,
            'date'                      => $this->date,
            'delivered_by'              => new EmployeeSimpleResource($this->responsible),
            'notes'                     => $this->notes,
            'created_at'                => $this->created_at,
            'update_at'                 => $this->updated_at,
            'items'                     => OrderItemResource::collection($this->orderItems)
        ];
    }
}
