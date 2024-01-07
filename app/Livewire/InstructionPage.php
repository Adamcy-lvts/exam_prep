<?php

namespace App\Livewire;

use Livewire\Component;

class InstructionPage extends Component
{
    public $showConfirmationModal = false;

    public $subjectId;

    function mount($id)
    {
        $this->subjectId = $id;
    }
    function startQuiz()
    {
        redirect()->route('start.exam', $this->subjectId);
    }

    public function showStartQuizConfirmation()
    {
        // Any preparatory logic before showing the modal goes here

        // Show the modal
        $this->showConfirmationModal = true;
    }

    public function render()
    {
        return view('livewire.instruction-page');
    }
}
