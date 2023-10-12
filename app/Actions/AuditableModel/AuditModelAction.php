<?php

namespace App\Actions\AuditableModel;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class AuditModelAction
{
    /**
     * Check if the model supports audit logs.
     *
     * @param Model $model The model for which audit logs are checked.
     *
     * @return bool
     */
    protected function isModelSupportAuditLogs(Model $model): bool
    {
        return method_exists($model, 'audit_logs') && $model->audit_logs() instanceof MorphMany;
    }
}
