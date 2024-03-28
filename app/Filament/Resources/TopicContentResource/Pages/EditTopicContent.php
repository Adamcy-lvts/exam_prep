<?php

namespace App\Filament\Resources\TopicContentResource\Pages;

use App\Filament\Resources\TopicContentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTopicContent extends EditRecord
{
    protected static string $resource = TopicContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
