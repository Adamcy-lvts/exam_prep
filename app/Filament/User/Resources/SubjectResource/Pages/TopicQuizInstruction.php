<?php

namespace App\Filament\User\Resources\SubjectResource\Pages;

use App\Filament\User\Resources\SubjectResource;
use Filament\Resources\Pages\Page;

class TopicQuizInstruction extends Page
{
    protected static string $resource = SubjectResource::class;

    protected static string $view = 'filament.user.resources.subject-resource.pages.topic-quiz-instruction';
}
