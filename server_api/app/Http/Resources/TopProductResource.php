<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TopProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'id'                => $this->id,
            'name'              => $this->name,
            'type'              => $this->type,
            'description'       => $this->description,
            'photo_url'         => ($this->photo_url != '' ? env('LOCAL_FILE_PATH_PRODUCTS', 'http://server_api.test/storage/products/') . $this->photo_url : ''),
            'price'             => (float) $this->price,
            'total_quantity'    => (int) $this->total_quantity
        ];
    }
}
