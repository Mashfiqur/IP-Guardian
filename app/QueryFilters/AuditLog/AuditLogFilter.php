<?php

namespace App\QueryFilters\AuditLog;

use App\QueryFilters\Base\QueryFilter;
use Illuminate\Database\Eloquent\Builder;

class AuditLogFilter extends QueryFilter {

    /**
     * Filter by action type
     *
     * @param  string $values
     * @return object<\Illuminate\Database\Eloquent\Builder>
     */
    public function action_type($values): Builder
    {
        return $this->builder->whereIn('action_type', $values);
    }

    /**
     * Filter by who took the action
     *
     * @param  string $values
     * @return object<\Illuminate\Database\Eloquent\Builder>
     */
    public function actioned_by($values): Builder
    {
        return $this->builder->whereHas('actioned_by_user', function($query) use ($values) {
            $query->whereIn(config('uuid.column'), $values);
        });
    }

    /**
     * Filter by status. This is for Soft Delete & Trash feature 
     * status: 1=Active, 2==Trash
     *
     * @param  string $values
     * @return object<\Illuminate\Database\Eloquent\Builder>
     */
    public function status($values): Builder
    {
        if($values === 2){
            return $this->builder->onlyTrashed();
        }
    }
}