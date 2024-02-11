<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\QuizPricing;

class PricingPlans extends Component
{
    public $pricingPlans;

    public function mount()
    {
        $this->pricingPlans = QuizPricing::all();
    }

    public function render()
    {
        return view('livewire.pricing-plans')->layout('filament.user.resources.subject-resource.pages.pricing-page');
    }
}
