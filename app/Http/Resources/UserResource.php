<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function __construct($user, $token)
    {
        $this->resource = $user;
        $this->token = $token;
    }

    public function toArray($request)
    {
        return [
            'status' => 'success',
            'user' => [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'address' => $this->address,
                'phone_number' => $this->phone_number,
            ],
            'token' => $this->token,
        ];
    }
}
