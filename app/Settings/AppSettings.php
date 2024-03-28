<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class AppSettings extends Settings
{
    public string $site_name;
    public string $timezone;
    public bool $maintenance_mode;
    public string $admin_email;
    public ?string $logo;
 

    public static function group(): string
    {
        return 'App';
    }
}