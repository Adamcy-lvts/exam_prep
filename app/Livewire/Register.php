<?php

namespace App\Livewire;

use Livewire\Component;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Concerns\InteractsWithForms;

class Register extends Component implements HasForms
{

    use InteractsWithForms;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title'),
                TextInput::make('slug'),
                RichEditor::make('content'),
            ]);
    }

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }


    public function render()
    {
        return view('livewire.register');
    }
}
