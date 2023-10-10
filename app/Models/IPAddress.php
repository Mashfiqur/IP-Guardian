<?php

namespace App\Models;

use App\Concerns\Models\HasUuid;
use Illuminate\Database\Eloquent\Model;
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


    protected $table = 'ip_addresses';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

}
