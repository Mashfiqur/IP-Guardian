<?php

namespace App\Models;

use App\Concerns\AuditableModel\Auditable;
use App\Concerns\Model\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class IPAddress extends Model
{
    /**
     * Provide soft delete related functionality
     */
    use SoftDeletes;


    /**
     * Provide UUID
    */
    use HasUuid;


    /**
     * Audit Events(Create, Update, Soft Delete, Restore, Delete )
    */
    use Auditable;


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

    protected function scopeFilter($query){
        return $query
            ->when(request('status') == 2, function ($query) { 
                // status: 1=Active, 2==Trash
                $query->onlyTrashed();
            })
            ->when(request('query'), function ($query){
                $query->whereLike(['ip', 'label', 'comment'], request('query'));
            })
            ->orderBy(
                request('sort_by_column', 'created_at'),
                request('sort_by_order', 'DESC'),
            );
    }
}
