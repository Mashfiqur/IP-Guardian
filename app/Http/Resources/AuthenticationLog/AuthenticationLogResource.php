<?php

namespace App\Http\Resources\AuthenticationLog;

use App\Http\Resources\User\UserBasicResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthenticationLogResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'id'                => $this->getId(),
            'ip_address'        => $this->ip_address,
            'user_agent'        => $this->user_agent,
            'user'              => new UserBasicResource($this->whenLoaded('user')),
            'login_at'          => $this->login_at ? date('Y-m-d h:i A', strtotime($this->login_at)) : null,
            'logout_at'         => $this->logout_at ? date('Y-m-d h:i A', strtotime($this->logout_at)) : null,
        ];
    }
}