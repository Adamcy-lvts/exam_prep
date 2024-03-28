<?php

namespace App\Filament\Resources\TopicContentResource\Pages;

use App\Filament\Resources\TopicContentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTopicContents extends ListRecords
{
    protected static string $resource = TopicContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
