<?php

namespace App\Filament\Resources\QuizAnswerResource\Pages;

use App\Filament\Resources\QuizAnswerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuizAnswer extends EditRecord
{
    protected static string $resource = QuizAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
