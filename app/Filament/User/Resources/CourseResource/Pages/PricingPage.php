<?php

namespace App\Filament\User\Resources\CourseResource\Pages;

use App\Models\Plan;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Auth;
use App\Filament\User\Resources\CourseResource;

class PricingPage extends Page
{
    protected static string $resource = CourseResource::class;

    protected static string $view = 'filament.user.resources.course-resource.pages.pricing-page';

    public $pricingPlans;
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
        $this->pricingPlans = Plan::where('type', 'course')->get();

    }
}
