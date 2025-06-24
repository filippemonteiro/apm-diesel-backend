<?php

namespace App\Jobs;

use App\Services\ML\NotificationsMlServices;
use App\Services\NotificationsServices;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class StoreNotificationMl implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $params;
    private $notificationsServices;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($notificationsServices, $params)
    {
        $this->params = $params;
        $this->notificationsServices = $notificationsServices;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $notificationsServicesML = new NotificationsMlServices();
        $result = $notificationsServicesML->getResource($this->params);
        $this->notificationsServices->createFactory($this->params['topic'], $result);
        Log::info("Notifications: " . $this->params['topic']. ' - Resources: '.$this->params['resource']);
    }
}
