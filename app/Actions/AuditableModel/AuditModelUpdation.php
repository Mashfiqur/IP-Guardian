<?php

namespace App\Actions\AuditableModel;

use App\Enums\AuditLogActionTypeEnum;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AuditModelUpdation extends AuditModelAction
{
    /**
     * When Model is updated, then store an audit log to database
     *
     * @param Model $previousModel The previous model state.
     * @param Model $updatedModel  The updated model state.
     * @param User $actionTaker    The user who initiated the action.
     * 
     * @return void
     */
    public static function log(Model $previousModel, Model $updatedModel, User $actionTaker): void
    {
        $self = new self;

        if ( ! $self->shouldLog($previousModel, $updatedModel) ) { return; }

        $difference = $self->getChangedAttributes($previousModel, $updatedModel);

        if( ! count($difference) ) { return; }

        $auditLog = new AuditLog([
            'action_type' => AuditLogActionTypeEnum::UPDATE,
            'difference'  => json_encode($difference),
            'actioned_by' => $actionTaker->id,
        ]);

        $updatedModel->audit_logs()->save($auditLog);
    }

    /**
     * Determine if an audit log should be created.
     *
     * @param Model $previousModel The previous model state.
     * @param Model $updatedModel  The updated model state.
     *
     * @return bool
     */
    protected function shouldLog(Model $previousModel, Model $updatedModel): bool
    {
        return $this->areModelsOfSameType($previousModel, $updatedModel)  &&
               $this->isModelSupportAuditLogs($updatedModel);
    }


    /**
     * Check if both models are of the same type.
     *
     * @param Model $previousModel The previous model state.
     * @param Model $updatedModel  The updated model state.
     *
     * @return bool
     */
    protected function areModelsOfSameType(Model $previousModel, Model $updatedModel): bool
    {
        return get_class($previousModel) === get_class($updatedModel);
    }


    /**
     * Get the changed attributes between two models.
     *
     * @param Model $previousModel The previous model state.
     * @param Model $updatedModel  The updated model state.
     *
     * @return array
     */
    protected function getChangedAttributes (Model $previousModel, Model $updatedModel): array
    {
        if ( ! method_exists($updatedModel, 'getAuditableColumns')) { return []; }

        $auditableColumns = $updatedModel->getAuditableColumns();

        $differences = [];

        foreach ($auditableColumns as $column) {
            $previousValue = $previousModel->{$column};
            $currentValue = $updatedModel->{$column};
    
            if ($previousValue !== $currentValue) {
                $differences[$column] = [
                    $previousValue ?? "", 
                    $currentValue ?? "",
                ];
            }
        }

        return $differences;
    }
}
