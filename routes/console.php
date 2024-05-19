<?php

use App\Models\Bank;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('fetch:banks', function () {
    $this->info('Fetching banks from Paystack...');

    $response = Http::withToken(config('services.paystack.secret'))
        ->get('https://api.paystack.co/bank');

    if ($response->successful()) {
        $banks = $response->json()['data'];
        foreach ($banks as $bank) {
            Bank::updateOrCreate(
                ['code' => $bank['code']],
                ['name' => $bank['name']]
            );
        }
        $this->info('Banks list fetched and saved successfully.');
    } else {
        Log::error('Failed to fetch banks list: ' . $response->body());
        $this->error('Failed to fetch banks list. Check the logs for more details.');
    }
})->describe('Fetch the list of banks from Paystack and save to the database');