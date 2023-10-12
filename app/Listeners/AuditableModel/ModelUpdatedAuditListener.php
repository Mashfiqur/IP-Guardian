<?php

namespace App\Listeners\AuditableModel;

use App\Actions\AuditableModel\AuditModelUpdation;
use App\Events\AuditableModel\AuditableModelUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ModelUpdatedAuditListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(AuditableModelUpdated $event): void
    {
        AuditModelUpdation::log($event->previousModel, $event->updatedModel, $event->actionTaker);
    }
}
