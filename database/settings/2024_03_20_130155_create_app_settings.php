<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateAppSettings extends SettingsMigration
{

    public function up(): void
    {
        $this->migrator->add('app.site_name', 'Exam Prep');
        $this->migrator->add('app.timezone', 'Africa/Lagos');
        $this->migrator->add('app.maintenance_mode', false);
        $this->migrator->add('app.admin_email', 'lv4mj1@gmail.com');
        $this->migrator->add('app.logo', 'images/site_logo.jpg');

    }
};
