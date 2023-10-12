<?php

namespace App\Concerns\AuditableModel;

use App\Concerns\TableAttributeConcern;

trait Auditable
{
    /**
     * Get the Auditable Columns
     *
     * @return array
     */
    public function getAuditableColumns(): array
    {
    	return $this->auditable_columns ?? [];
    }
}