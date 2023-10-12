<?php

namespace App\Events\AuditableModel;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AuditableModelCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The model which has just created
     *
     * @var object
     */
    public $model;

    /**
     * Action Taker
     *
     * @var object
     */
    public $actionTaker;


    /**
     * Create a new event instance.
     */
    public function __construct($model, User $actionTaker)
    {
        $this->model        = $model;
        $this->actionTaker  = $actionTaker;
    }
}
