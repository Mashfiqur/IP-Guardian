<?php

namespace App\Http\Resources\AuditLog;

use App\Http\Resources\User\UserBasicResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AuditLogResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) {
        return [
            'id'                => $this->getId(),
            'action_type'       => $this->action_type->toString(),
            'actioned_by'       => new UserBasicResource($this->whenLoaded('actioned_by_user')),
            'difference'        => json_decode($this->difference, true),
        ];
    }
}