<?php

namespace App\Listeners\AuditableModel;

use App\Actions\AuditableModel\AuditModelCreation;
use App\Events\AuditableModel\AuditableModelCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ModelCreatedAuditListener
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
    public function handle(AuditableModelCreated $event): void
    {
        AuditModelCreation::log($event->model, $event->actionTaker);
    }
}
