<?php

namespace App\Models;

use App\Concerns\AuditableModel\Auditable;
use App\Concerns\Model\Filterable;
use App\Concerns\Model\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class IPAddress extends Model
{
    /**
     * Provide mock data creation functionality for testing
     */
    use HasFactory;

    /**
     * Provide soft delete related functionality
     */
    use SoftDeletes;

    /**
     * Provide UUID
    */
    use HasUuid;

    /**
     * Provide filtering from request
    */
    use Filterable;

    /**
     * Audit Events(Create, Update, Soft Delete, Restore, Delete )
    */
    use Auditable;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'ip_addresses';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    /**
     * The attributes that are auditable.
     *
     * @var array
     */
    protected $auditable_columns = ["label", 'comment'];

    /**
     * Get all of the audit logs of IP Address.
     */
    public function audit_logs(): MorphMany
    {
        return $this->morphMany(AuditLog::class, 'loggable');
    }    
}
