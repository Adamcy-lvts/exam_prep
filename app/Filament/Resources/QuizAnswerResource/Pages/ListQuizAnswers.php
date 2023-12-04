<?php

namespace App\Filament\Resources\QuizAnswerResource\Pages;

use App\Filament\Resources\QuizAnswerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQuizAnswers extends ListRecords
{
    protected static string $resource = QuizAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
