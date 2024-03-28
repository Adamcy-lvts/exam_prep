<?php

namespace App\Filament\User\Widgets;

use Filament\Widgets\Widget;

class FilamentInfoWidget extends Widget
{
    protected static ?int $sort = -2;

    protected static bool $isLazy = false;

    /**
     * @var view-string
     */
    protected static string $view = 'filament.user.widgets.filament-info-widget';

    public $user;

    public function mount(): void
    {
        $this->user = auth()->user();
    }
}
