<?php

namespace App\Filament\User\Resources\CourseResource\Pages;

use App\Filament\User\Resources\CourseResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCourse extends CreateRecord
{
    protected static string $resource = CourseResource::class;
}
