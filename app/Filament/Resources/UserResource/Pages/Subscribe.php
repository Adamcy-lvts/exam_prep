<?php

namespace App\Filament\Resources\UserResource\Pages;

use Exception;
use Filament\Forms;

use App\Models\Plan;
use Filament\Tables;
use App\Models\Payment;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Support\RawJs;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\UserResource;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;

class Subscribe extends Page
{
    protected static string $resource = UserResource::class;

    protected static string $view = 'filament.resources.user-resource.pages.subscribe';
    public $user_id;
    public $user;
    public $plan_id;
    public $amount;
    public $method;
    public $plan;


    use InteractsWithRecord;

    public function mount(int | string $record): void
    {

        $this->record = $this->resolveRecord($record);

        

        $this->form->fill([
            'user_id' => $this->record->id,
            'user' => $this->record->first_name . ' ' . $this->record->last_name,

        ]);
    }


    public function form(Form $form): Form
    {
        return $form
            ->schema([

                TextInput::make('user_id')->hidden(),
                TextInput::make('user')->disabled(),
                Select::make('plan_id')->options(
                    Plan::all()->pluck('title', 'id')
                )->label('Plan')->preload()->live()
                    ->afterStateUpdated(function (Get $get, Set $set) {

                        $this->plan_id = $get('plan_id');

                        $plan = Plan::find($this->plan_id);
                        // dd($plan);
                        $set('amount', $plan->price);
                    }),
                TextInput::make('amount')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric(),


                Select::make('method')->options([
                    'card' => 'Card',
                    'bank' => 'Bank Transfer',
                    'cash' => 'Cash',
                    'pos' => 'POS',
                ])->default('card'),
            ])->columns(2);
    }

    public function create(): void
    {
        // dd($this->form->getState());
        $this->plan = Plan::find($this->plan_id);
        // Record the payment
        $payment = new Payment([
            'user_id' => $this->record->id,
            'amount' =>  $this->amount,
            'method' => $this->method,
            'plan_id' =>  $this->plan_id,
            'attempts_purchased' => $this->plan->number_of_attempts,
            'status' => 'completed',
            'transaction_ref' => Null,
        ]);
        $payment->save();

        $this->manageSubscription($this->record, $this->plan);


    
        Notification::make()
            ->title('Subscription successful')
            ->success()
            ->send();
        $this->redirectRoute('filament.admin.resources.subscriptions.index');
       
    }

    private function manageSubscription($record, $plan)
    {
        // Retrieve any active subscription, regardless of the plan.
        $currentSubscription = $record->subscriptions()
            ->where('ends_at', '>', now())
            ->orderBy('ends_at', 'desc') // In case there are multiple, get the latest.
            ->first();

        $expiresAt = now()->addDays($plan->validity_days ?? 0);

        if ($currentSubscription) {
            // If switching between different plans...
            if ($currentSubscription->plan_id != $plan->id) {
                // Optional: Determine if any proration or adjustments are needed.
                // This might involve calculating the unused portion of the current subscription
                // and applying its value towards the new subscription, adjusting the `expiresAt` accordingly.

                // End the current subscription early.
                $currentSubscription->update(['status' => 'cancelled', 'ends_at' => now(), 'cancelled_at' => now()]);

                // Create a new subscription for the new plan.
                $this->createNewSubscription($record, $plan, $expiresAt);
            } else {
                // If re-purchasing the same plan, extend the existing subscription.
                $currentSubscription->update(['ends_at' => $expiresAt]);
            }
        } else {
            // If no active subscription exists, create a new subscription.
            $this->createNewSubscription($record, $plan, $expiresAt);
        }

        // Reset attempts or apply other plan-specific logic.
        $this->resetAttempts($record, $plan);
    }

    private function createNewSubscription($record, $plan, $expiresAt)
    {
        $record->subscriptions()->create([
            'plan_id' => $plan->id,
            'starts_at' => now(),
            'ends_at' => $expiresAt,
            'status' => 'active', // Consider your logic for setting status
            'features' => $plan->features // Copying features from plan to subscription
        ]);
    }

    private function resetAttempts($record, Plan $plan)
    {
        // Update the attempts based on the purchased plan
        switch ($plan->type) {
            case 'subject':
                // Check if the plan offers unlimited attempts
                $this->resetSubjectAttempts($record, $plan);
                break;
            case 'course':
                $this->resetCourseAttempts($record, $plan);
                break;
            default:
                // Handle other plan types or throw an exception if unknown
                throw new Exception('Unknown plan type.');
        }
    }

    public function resetSubjectAttempts($record, Plan $plan)
    {
        // Retrieve all subjects for the user
        $subjects = $record->subjects;

        // // Iterate over each subject to reset attempts
        foreach ($subjects as $subject) {
            $subjectAttempt = $record->subjectAttempts()->where('subject_id', $subject->id)->first();

            // If there is an existing subject attempt record, reset attempts to 0
            if ($subjectAttempt) {
                $subjectAttempt->update(['attempts_left' => 0]);
            }
        }

        // Retrieve the user's JAMB attempt record
        $jambAttempt = $record->jambAttempts()->first();

        // // If there is an existing JAMB attempt record, reset attempts to 0
        if ($jambAttempt) {
            $jambAttempt->update(['attempts_left' => 0]);
        }
        // Check if the plan offers unlimited attempts
        if (is_null($plan->number_of_attempts)) {
            // Set attempts_left to null for unlimited attempts
            $subjects = $record->subjects;
            foreach ($subjects as $subject) {
                $record->subjectAttempts()->updateOrCreate(
                    ['subject_id' => $subject->id],
                    ['attempts_left' => null] // Indicate unlimited attempts
                );
            }
            $jambAttempt = $record->jambAttempts()->first();
            if ($jambAttempt) {
                $jambAttempt->attempts_left = null; // Indicate unlimited attempts
                $jambAttempt->save();
            } else {
                $record->jambAttempts()->create([
                    'attempts_left' => null // Set specific number of attempts
                ]);
            }
        } else {
            // For plans with a limited number of attempts
            $subjects = $record->subjects;
            foreach ($subjects as $subject) {
                $record->subjectAttempts()->updateOrCreate(
                    ['subject_id' => $subject->id],
                    ['attempts_left' => $plan->number_of_attempts]
                );
            }

            $jambAttempt = $record->jambAttempts()->first();
            if ($jambAttempt) {
                $jambAttempt->increment('attempts_left', $plan->number_of_attempts);
            } else {
                $record->jambAttempts()->create([
                    'attempts_left' => $plan->number_of_attempts // Set specific number of attempts
                ]);
            }
        }
    }

    public function resetCourseAttempts($record, Plan $plan)
    {
        if ($record->courses->count() > 0) {
            if (is_null($plan->number_of_attempts)) {
                // Set attempts_left to null for unlimited attempts
                $courses = $record->courses;
                foreach ($courses as $course) {
                    $record->courseAttempts()->updateOrCreate(
                        ['course_id' => $course->id],
                        ['attempts_left' => null] // Indicate unlimited attempts
                    );
                }
            } else {
                // For plans with a limited number of attempts
                $courses = $record->courses;
                foreach ($courses as $course) {
                    $record->courseAttempts()->updateOrCreate(
                        ['course_id' => $course->id],
                        ['attempts_left' => $plan->number_of_attempts]
                    );
                }
            }
        }
    }
}
