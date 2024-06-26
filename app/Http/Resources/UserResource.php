<?php

namespace App\Http\Resources;

use App\Models\Role;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public static $wrap = false;
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
            'username' => $this->username,
            'ec_number' => $this->ec_number,
            'email' => $this->email,
            'phone' => $this->phone,
            'role_id' => $this->role_id,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
