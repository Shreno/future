<?php

namespace App\Jobs;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Str;

class SaveMerchantDataFromProvider implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $merchantDetails;
    protected $webHookData;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($merchantDetails,$webHookData)
    {
        $this->merchantDetails = $merchantDetails;
        $this->webHookData = $webHookData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        User::create([
            'avatar' => $this->merchantDetails->data->merchant->avatar,
            'name'   => $this->merchantDetails->data->name,
            'user_type' => 'client',
            'email' => $this->merchantDetails->data->email,
            'email_verified_at' => now(),
            'password' => Str::random(10),
            'domain' => $this->merchantDetails->data->merchant->domain,
            'store_name' => $this->merchantDetails->data->merchant->name,
            'logo' => $this->merchantDetails->data->merchant->avatar,
            'phone' => $this->merchantDetails->mobile ?? null,
            'website' => $this->merchantDetails->data->merchant->domain,
            'provider' => 'salla',
            'merchant_id' => $this->merchantDetails->data->merchant->id,
            'client_name' => $this->merchantDetails->data->name,
            'client_email' =>  $this->merchantDetails->data->email,
            'client_mobile' => $this->merchantDetails->mobile ?? null,
            'provider_store_owner_name' => $this->merchantDetails->data->merchant->username,
            'provider_store_id' => $this->merchantDetails->data->id,
            'provider_store_name' => $this->merchantDetails->data->merchant->name,
            'provider_access_token' => $this->webHookData->access_token,
            'provider_refresh_token' => $this->webHookData->refresh_token,
            'provider_access_expiry'=> gmdate('Y-m-d H:i:s',$this->webHookData->expires),
            'default_status_id' => 1
        ]);
    }
}
