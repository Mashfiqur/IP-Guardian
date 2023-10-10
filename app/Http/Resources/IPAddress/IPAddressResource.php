<?php

namespace App\Http\Resources\IPAddress;

use Illuminate\Http\Resources\Json\JsonResource;

class IPAddressResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'id'            => $this->getId(),
            'label'         => $this->label,
            'ip'            => $this->ip,
            'comment'       => $this->comment,
        ];
    }
}