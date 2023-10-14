<?php

namespace App\Http\Controllers;

use App\Events\AuditableModel\AuditableModelCreated;
use App\Events\AuditableModel\AuditableModelUpdated;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\IPAddress\StoreIPAddressRequest;
use App\Http\Requests\IPAddress\UpdateIPAddressRequest;
use App\Http\Resources\IPAddress\IPAddressResource;
use App\Models\IPAddress;
use App\QueryFilters\IpAddress\IpAddressFilter;

class IPAddressController extends Controller 
{

    protected $resourceModel;

    public function __construct(IPAddress  $resourceModel) {
        $this->resourceModel = $resourceModel;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ipAddresses = $this->resourceModel
                ->filter(new IpAddressFilter($request))
                ->orderBy(
                    request('order_by_column', 'created_at'),
                    request('order_direction', 'DESC'),
                )
                ->paginate(request('per_page'), ['*'], 'page', request('page'));

        return IPAddressResource::collection($ipAddresses);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\IPAddress\StoreIPAddressRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreIPAddressRequest $request) 
    {
        $validateds = $request->validated();

        $ipAddress = $this->resourceModel->create( $validateds );

        event(new AuditableModelCreated($ipAddress, auth()->user()));

        return new IPAddressResource($ipAddress);
    }


    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ipAddress = $this->resourceModel
                    ->with([
                        'audit_logs.actioned_by_user',
                    ])
                    ->findByUuidOrFail($id);

        return new IPAddressResource($ipAddress);
    }

    /**
     * Edit the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ipAddress = $this->resourceModel->findByUuidOrFail($id);

        return new IPAddressResource($ipAddress);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateIPAddressRequest $request, $id) 
    {
        $ipAddress = $this->resourceModel->findByUuidOrFail($id);

        $previousIpAddress = clone $ipAddress;

        $ipAddress->update($request->validated());

        $updatedIpAddress = $ipAddress->refresh();

        event(new AuditableModelUpdated($previousIpAddress, $updatedIpAddress, auth()->user()));

        return new IPAddressResource($updatedIpAddress);
    }
}