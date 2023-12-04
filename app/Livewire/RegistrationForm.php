<?php

namespace App\Livewire;

use Filament\Forms;
use App\Models\User;
use App\Models\Course;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Forms\Components\Grid;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Concerns\InteractsWithActions;

class RegistrationForm extends Component implements HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Register')
                    ->description('Fil out the form to register and have your own dashboard')
                    ->icon('heroicon-m-user')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('first_name')->required(),
                                TextInput::make('last_name')->required(),
                                TextInput::make('email')->required(),
                                TextInput::make('phone')->numeric()->required(),
                                Select::make('courses')->multiple()->options(Course::all()->pluck('title', 'id')->toArray())->columnSpanFull()->required(),
                                TextInput::make('password')->required(),
                                TextInput::make('confirm_password')->required(),
                            ]),

                    ])
            ])->columns(2)
            ->statePath('data')
            ->model(User::class);
    }

    // public function create(): void
    // {
    //     $data = $this->form->getState();
    //     // dd($data);
    //     $user = User::create($data);

    //     $this->form->model($user)->saveRelationships();

    //     Auth::login($user);

    //     redirect('/user'); // Redirect to the desired endpoint
    // }

    public function create(): void
    {
        $data = $this->form->getState();

        // Separate the user data from the course IDs.
        $userData = collect($data)->except('courses')->all();
        $courseIds = $data['courses'] ?? [];

        // Create the user and hash their password.


        // dd($userData);
        $user = User::create([
            'name' => $data['first_name'],
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'phone'      => $data['phone'],
            'password'   => Hash::make($data['password']),
        ]);

        // Attach the courses to the user.
        $user->courses()->attach($courseIds);

        // Save any additional relationships if needed.
        $this->form->model($user)->saveRelationships();

        // Login the user.
        Auth::login($user);

        // Redirect to the desired endpoint.
        redirect('/user');
    }


    public function render(): View
    {
        return view('livewire.registration-form');
    }
}
