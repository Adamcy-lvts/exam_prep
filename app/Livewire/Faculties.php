<?php

namespace App\Livewire;

use App\Models\Faculty;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Faculties extends Component
{
    public $faculties;

    public function mount()
    {
        $this->faculties = Faculty::all();
    }
    public function render()
    {

        return view('livewire.faculties');
    }
}
