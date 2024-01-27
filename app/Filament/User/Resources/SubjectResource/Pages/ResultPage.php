<?php

namespace App\Filament\User\Resources\SubjectResource\Pages;

use Filament\Resources\Pages\Page;
use App\Filament\Traits\ResultPageTrait;
use App\Filament\User\Resources\SubjectResource;

class ResultPage extends Page
{
    use ResultPageTrait;
    
    protected static string $resource = SubjectResource::class;

    protected static string $view = 'filament.user.resources.subject-resource.pages.result-page';


}
