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
            'loggable_type'     => class_basename($this->loggable_type),
            'loggable_id'       => $this->relationLoaded('loggable') ? $this->loggable->getId() : null,
            'action_type'       => $this->action_type->toString(),
            'actioned_by'       => new UserBasicResource($this->whenLoaded('actioned_by_user')),
            'difference'        => $this->difference ? json_decode($this->difference, true) : null,
            'actioned_at'       => date('Y-m-d h:i A', strtotime($this->created_at))  // This datetime format can be handled through config file or a settings table in future
        ];
    }
}