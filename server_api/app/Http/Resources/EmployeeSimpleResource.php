<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeSimpleResource extends JsonResource
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
            'name'      => $this->name,
            'photo_url' => ($this->photo_url != '' ? env('LOCAL_FILE_PATH_AVATARS', 'http://server_api.test/storage/fotos/') . $this->photo_url : ''),
        ];
    }
}
