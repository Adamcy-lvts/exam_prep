<?php

namespace App\Filament\User\Resources\SubjectResource\Pages;

use App\Models\Plan;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Auth;
use App\Filament\User\Resources\SubjectResource;

class PricingPage extends Page
{
    protected static string $resource = SubjectResource::class;

    protected static string $view = 'filament.user.resources.subject-resource.pages.pricing-page';

    public $pricingPlans;
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
        $this->pricingPlans = Plan::all();
    }
}
