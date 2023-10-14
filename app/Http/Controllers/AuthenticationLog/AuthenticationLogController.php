<?php

namespace App\Http\Controllers\AuthenticationLog;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthenticationLog\AuthenticationLogResource;
use App\Models\AuthenticationLog;
use Illuminate\Http\Request;

class AuthenticationLogController extends Controller 
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
    public function __construct(AuthenticationLog  $resourceModel) {
        $this->resourceModel = $resourceModel;
    }

    /**
     * Fetch audit log
     *
     * @param \Illuminate\Http\Request
     */
    public function index(Request $request)
    {
        $authenticationLogs = $this->resourceModel
                        ->with([
                            'user' => function ($query){
                                $query->select([
                                    'id',
                                    config('uuid.column'),
                                    'name',
                                    'email'
                                ]);
                            }, 
                        ])
                        ->orderBy(
                            request('order_by_column', 'created_at'),
                            request('order_direction', 'DESC'),
                        )
                        ->paginate(request('per_page'), ['*'], 'page', request('page'));

        return AuthenticationLogResource::collection($authenticationLogs);
    }
}