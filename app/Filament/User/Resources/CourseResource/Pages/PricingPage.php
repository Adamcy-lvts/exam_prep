<?php

namespace App\Filament\User\Resources\CourseResource\Pages;

use App\Filament\User\Resources\CourseResource;
use Filament\Resources\Pages\Page;

class PricingPage extends Page
{
    protected static string $resource = CourseResource::class;

    protected static string $view = 'filament.user.resources.course-resource.pages.pricing-page';
}
