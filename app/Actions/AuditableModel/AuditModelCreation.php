<?php

namespace App\Actions\AuditableModel;

use App\Enums\AuditLog\AuditLogActionTypeEnum;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AuditModelCreation extends AuditModelAction
{
    /**
     * When Model is created, then store an audit log to database
     *
     * @param  $model
     * @param  \App\Models\User $actionTaker
     * 
     */
    public static function log(Model $model, User $actionTaker): void
    {
        $self = new self;

        if ( ! $self->isModelSupportAuditLogs($model) ) { return; }

        $auditLog = new AuditLog([
            'action_type' => AuditLogActionTypeEnum::CREATE,
            'actioned_by' => $actionTaker->id,
        ]);
        
        $model->audit_logs()->save($auditLog);
    }
}
