<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use App\Settings\AppSettings;
use Filament\Pages\SettingsPage;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ToggleButtons;

class Settings extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = AppSettings::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('site_name')
                    ->label('Site Name')
                    ->required(),

                TextInput::make('timezone')
                    ->label('Timezone')
                    ->required(),
                Toggle::make('maintenance_mode')->label('Maintenance Mode'),
                TextInput::make('admin_email')->label('Admin Email')->required(),
                FileUpload::make('logo')->label('Site Logo')->preserveFilenames(),
            ]);
    }
}
