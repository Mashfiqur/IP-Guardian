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

class AuditableModelUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The previous model
     *
     * @var object
     */
    public $previousModel;

    
     /**
     * The updated model
     *
     * @var object
     */
    public $updatedModel;

    /**
     * Action Taker
     *
     * @var object
     */
    public $actionTaker;

    /**
     * Create a new event instance.
     */
    public function __construct($previousModel, $updatedModel, User $actionTaker)
    {
        $this->previousModel    = $previousModel;
        $this->updatedModel     = $updatedModel;
        $this->actionTaker      = $actionTaker;
    }
}
