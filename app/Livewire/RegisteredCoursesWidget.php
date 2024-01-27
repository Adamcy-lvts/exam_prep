<?php

namespace App\Livewire;

use Filament\Widgets\Widget;

class RegisteredCoursesWidget extends Widget
{
    protected static string $view = 'livewire.registered-courses-widget';


    public $course;

    public function mount($course)
    {

        $this->course = $course;

        // dd($this->subject);
    }
}
