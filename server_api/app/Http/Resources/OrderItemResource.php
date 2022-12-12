<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $status = ["W" => "Waiting", "P" => "Preparing", "R" => "Ready"];
        return [
            'order_id'              => $this->order_id,
            'order_local_number'    => $this->order_local_number,
            'product'               => new ProductResource($this->product),
            'status'                => $status[$this->status],
            'price'                 => $this->price,
            'preparation_by'        => new EmployeeResource($this->employee),
            'notes'                 => $this->notes,
            'custom'                => $this->custom,
        ];
    }
}
