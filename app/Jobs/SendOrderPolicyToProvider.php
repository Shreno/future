<?php

namespace App\Jobs;

use App\ProvidersIntegration\Salla\UpdateOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class SendOrderPolicyToProvider implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
         $pdf = PDF::loadView('website.show-as-pdf', ['order' => $this->order]);
        if(! file_exists(public_path('orders/'.$this->order->order_id.'.pdf'))){
            $pdf->save(public_path('orders/'.$this->order->order_id.'.pdf'));
        }
        
        $updateOrder = new UpdateOrder();
        $updateOrder->updatePolicy($this->order);
    }
}
