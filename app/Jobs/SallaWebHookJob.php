<?php

namespace App\Jobs;

use App\Address;
use App\AppSetting;
use App\City;
use App\Helpers\Notifications;
use App\Helpers\OrderHistory;
use App\Order;
use App\ProvidersIntegration\Salla\MerchantDetail;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Spatie\WebhookClient\Jobs\ProcessWebhookJob;
use Spatie\WebhookClient\Models\WebhookCall;

class SallaWebHookJob extends ProcessWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(WebhookCall $webhookCall)
    {
        parent::__construct($webhookCall);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $webHookPayloadObject = json_decode(json_encode($this->webhookCall->payload));

        $className = str_replace(' ','',ucwords(str_replace('.',' ',$webHookPayloadObject->event)));
        $eventClass = "\App\Events\SallaEvents\{$className}";
        $eventClass = str_replace('}','',str_replace('{','',$eventClass));

        if(class_exists($eventClass)){
            event(new $eventClass($webHookPayloadObject));
        }
    }
}
