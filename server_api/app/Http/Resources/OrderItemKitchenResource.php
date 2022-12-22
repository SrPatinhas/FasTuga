<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemKitchenResource extends JsonResource
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
            'status'                => $status[$this->status],
            'price'                 => (float) $this->price,
            'quantity'              => (int) $this->product_quantity,
            'preparation_by'        => $this->preparation_by,
            'notes'                 => $this->notes,

            'product_id'        => $this->product->id,
            'product_name'      => $this->product->name,
            'product_type'      => $this->product->type,
            'product_photo_url' => ($this->product->photo_url != '' ? env('LOCAL_FILE_PATH_PRODUCTS', 'http://server_api.test/storage/products/') . $this->product->photo_url : ''),
        ];
    }
}
