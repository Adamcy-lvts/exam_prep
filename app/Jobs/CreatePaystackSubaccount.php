<?php

namespace App\Jobs;

use App\Models\Agent;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Unicodeveloper\Paystack\Facades\Paystack;

class CreatePaystackSubaccount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $agent;
    protected $subaccountData;

    public function __construct(Agent $agent, $subaccountData)
    {
        $this->agent = $agent;
        $this->subaccountData = $subaccountData;
    }

    public function handle()
    {
        try {
            $subaccount = Paystack::createSubAccount($this->subaccountData);
            $this->agent->update(['subaccount_code' => $subaccount['data']['subaccount_code']]);
        } catch (\Exception $e) {
            Log::error('Failed to create Paystack subaccount: ' . $e->getMessage());
            // Optional: Retry logic or notify admin via email or other channels
        }
    }
}
