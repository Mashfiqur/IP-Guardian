<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuditLog\GetAuditLogRequest;
use App\Http\Resources\AuditLog\AuditLogResource;
use App\Models\AuditLog;
use App\QueryFilters\AuditLog\AuditLogFilter;

class AuditLogController extends Controller 
{

    /**
     * The model instance
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $resourceModel;


    /**
     * @param \App\Models\AuditLog
     */
    public function __construct(AuditLog  $resourceModel) {
        $this->resourceModel = $resourceModel;
    }

    /**
     * Fetch audit log
     *
     * @param \App\Http\Requests\AuditLog\GetAuditLogRequest
     */
    public function index(GetAuditLogRequest $request)
    {
        $auditLogs = $this->resourceModel
                        ->with([
                            'loggable' => function ($query){
                                $query->select([
                                    'id',
                                    config('uuid.column')
                                ]);
                            }, 
                            'actioned_by_user' => function ($query){
                                $query->select([
                                    'id',
                                    config('uuid.column'),
                                    'name',
                                    'email',
                                ]);
                            }, 
                        ])
                        ->filter(new AuditLogFilter($request))
                        ->orderBy(
                            request('order_by_column', 'created_at'),
                            request('order_direction', 'DESC'),
                        )
                        ->paginate(request('per_page'), ['*'], 'page', request('page'));

        return AuditLogResource::collection($auditLogs);
    }
}