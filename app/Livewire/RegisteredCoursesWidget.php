<?php

namespace App\Livewire;

use Filament\Widgets\Widget;

class RegisteredCoursesWidget extends Widget
{
    protected static string $view = 'livewire.registered-courses-widget';


    public $course;

    public function mount($course)
    {

        // let's fetch only 4 courses for the user and randomize the courses if the user has more than registered courses

        //  $this->course = $course;
        $this->course = $course;
        // dd($this->course); 
        // ->inRandomOrder()->get();

        // dd($this->subject);
    }
}
