<?php

namespace App\Models;

use App\Concerns\Model\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class AuthenticationLog extends Model
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
     * Table name
     *
     * @var string
     */
    protected $table = 'authentication_logs';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the user that owns the authentication log.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
