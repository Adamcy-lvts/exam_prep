<?php

namespace App\Livewire;

use Filament\Widgets\Widget;

class RegisteredSubjectsWidget extends Widget
{
    protected static string $view = 'livewire.registered-subjects-widget';

    public $subject;

    public function mount($subject) {

        $this->subject = $subject;

        // dd($this->subject);
    }

    // protected function getViewData(): array
    // {
    //     return [
    //         'subject' => $this->subject
    //     ];
    // }
}
