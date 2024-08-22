<?php

use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;



Artisan::command("run:expirations", function() {
    Log::info("running the every minute job..");
    $exp_keys = \App\Models\AssetType::all()->whereNotNull('expiration_key');
    foreach ($exp_keys as $asset_type) {
        foreach($asset_type->assets()->cursor() as $asset) {
            if( isset($asset->data[$asset_type->expiration_key]) ){
                $expiration_date_str = $asset->data[$asset_type->expiration_key];
                $parts = explode('/', $expiration_date_str);
                if (count($parts) != 3) {
                    Log::error("Invalid expiration date format: " . $expiration_date_str);
                    continue;
                }
                $dt = Carbon::createFromDate($parts[2], $parts[0], $parts[1]);
                if ($dt->isPast()) {
                    Log::info("Asset expired: TODO send an email or whatever create an expiration object or whatever" . $asset->id);
                }
            }
        }
    }
    Log::info("Searching: " . $exp_keys);
})->daily();

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();
