<?php

namespace App\Filament\Resources\CompositeQuizSessionResource\Pages;

use App\Filament\Resources\CompositeQuizSessionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCompositeQuizSession extends EditRecord
{
    protected static string $resource = CompositeQuizSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
