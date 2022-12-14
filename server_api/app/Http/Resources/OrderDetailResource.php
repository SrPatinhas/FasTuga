<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
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
            'ticket_number'             => $this->ticket_number,
            'status'                    => $this->status,
            'status_label'              => $status[$this->status],
            'total_price'               => $this->total_price,
            'total_paid'                => $this->total_paid,
            'total_paid_with_points'    => $this->total_paid_with_points,
            'points_gained'             => $this->points_gained,
            'points_used_to_pay'        => $this->points_used_to_pay,
            'payment_type'              => $this->payment_type,
            'payment_reference'         => $this->payment_reference,
            'date'                      => $this->date,
            'delivered_by'              => $this->delivered_by,
            'custom'                    => $this->custom,
            'created_at'                => $this->created_at,
            'update_at'                 => $this->updated_at,
            'customer'                  => $this->customer_id ? new CustomerResource($this->customer) : null,
            'items'                     => OrderItemResource::collection($this->orderItems)
        ];
    }
}
