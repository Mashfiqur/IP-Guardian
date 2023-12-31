<?php

namespace App\Models;

use App\Concerns\Model\Filterable;
use App\Concerns\Model\HasUuid;
use App\Enums\AuditLog\AuditLogActionTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuditLog extends Model
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
     * Provide filtering from request
    */
    use Filterable;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'audit_logs';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'action_type' => AuditLogActionTypeEnum::class,
    ];

    /**
     * Get the parent loggable model.
     */
    public function loggable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the user who created the authentication log.
     */
    public function actioned_by_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actioned_by');
    }
}
