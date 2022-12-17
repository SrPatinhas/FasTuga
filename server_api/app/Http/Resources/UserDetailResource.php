<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailResource extends JsonResource
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
            'email'     => $this->email,
            'type'      => $this->type,
            'blocked'   => $this->blocked,
            'photo_url' => env('LOCAL_FILE_PATH_AVATARS') . $this->photo_url,
        ];
    }
}
