<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'photo_url' => ($this->photo_url != '' ? env('LOCAL_FILE_PATH_AVATARS', 'http://server_api.test/storage/fotos/') . $this->photo_url : ''),
        ];
    }
}
