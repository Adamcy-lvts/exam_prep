<?php

namespace App\Filament\Resources;

use Exception;
use Filament\Forms;
use App\Models\Plan;
use Filament\Tables;
use App\Models\Payment;
use Filament\Forms\Form;

use Filament\Tables\Table;
use Filament\Support\RawJs;
use Faker\Provider\ar_EG\Text;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PaymentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PaymentResource\RelationManagers;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'User & Subscription Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')->relationship(
                    name: 'user',
                    modifyQueryUsing: fn (Builder $query) => $query->orderBy('first_name')->orderBy('last_name'),
                )
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->first_name} {$record->last_name}")
                    ->searchable(['first_name', 'last_name']),
                TextInput::make('amount')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric(),
                Select::make('plan_id')->relationship(
                    name: 'plan',
                    modifyQueryUsing: fn (Builder $query) => $query->orderBy('title')->orderBy('price'),
                )
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->type} {$record->title} {$record->price}")
                    ->searchable(['type', 'title'])->preload(),

                Select::make('method')->options([
                    'card' => 'Card',
                    'bank' => 'Bank Transfer',
                    'cash' => 'Cash',
                    'pos' => 'POS',
                ])->default('card'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ViewColumn::make('Full Name')->view('filament.tables.columns.full-name'),
                TextColumn::make('amount')->money('NGN', true)->sortable()->copyable()->searchable(),
                TextColumn::make('method'),
                TextColumn::make('plan.type')->label('Plan Type'),
                TextColumn::make('plan.title')->label('Plan Title'),
                TextColumn::make('user.email')->label('Email Address')->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'completed' => 'success',
                    }),
                TextColumn::make('created_at')->label('Payment Date')->dateTime('F j, Y g:i A'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('Confirm Payment')
                    ->form([
                        Forms\Components\Select::make('newStatus')
                            ->options([
                                'completed' => 'Completed (Success)',
                                'failed' => 'Failed'
                            ])
                            ->required()
                            ->label('New Payment Status')
                    ])
                    ->action(function (Payment $record, array $data) {
                        $record->update(['status' => $data['newStatus']]);

                        DB::transaction(function () use ($record, $data) { // Use transaction for all operations
                            $record->update(['status' => $data['newStatus']]);

                            if ($data['newStatus'] === 'completed' && $record->payment_for === 'subscription plan') {
                                $plan = Plan::find($record->plan_id);
                                if ($plan) {
                                    // Manage the subscription logic here

                                    $currentSubscription = $record->user->subscriptions()
                                        ->where('ends_at', '>', now())
                                        ->orderBy('ends_at', 'desc')
                                        ->first();

                                    $expiresAt = now()->addDays($plan->validity_days ?? 0);

                                    if ($currentSubscription && $currentSubscription->plan_id != $plan->id) {
                                        $currentSubscription->update([
                                            'status' => 'cancelled',
                                            'ends_at' => now(),
                                            'cancelled_at' => now()
                                        ]);

                                        // Create a new subscription
                                        $record->user->subscriptions()->create([
                                            'plan_id' => $plan->id,
                                            'starts_at' => now(),
                                            'ends_at' => $expiresAt,
                                            'status' => 'active',
                                            'features' => $plan->features
                                        ]);
                                    } elseif ($currentSubscription) {
                                        // Extend the existing subscription
                                        $currentSubscription->update(['ends_at' => $expiresAt]);
                                    } else {
                                        // No active subscription, create a new one
                                        $record->user->subscriptions()->create([
                                            'plan_id' => $plan->id,
                                            'starts_at' => now(),
                                            'ends_at' => $expiresAt,
                                            'status' => 'active',
                                            'features' => $plan->features
                                        ]);
                                    }

                                    // Reset Attempts Logic: Set or reset the attempts based on the plan
                                    $subjects = $record->user->subjects;
                                    foreach ($subjects as $subject) {
                                        $attemptsLeft = $plan->number_of_attempts; // Could be null for unlimited
                                        $record->user->subjectAttempts()->updateOrCreate(
                                            ['subject_id' => $subject->id],
                                            ['attempts_left' => $attemptsLeft]
                                        );
                                    }

                                    // JAMB attempts logic
                                    $jambAttemptsLeft = $plan->number_of_attempts; // Could be null for unlimited
                                    $jambAttempt = $record->user->jambAttempts()->first();
                                    if ($jambAttempt) {
                                        $jambAttempt->update(['attempts_left' => $jambAttemptsLeft]);
                                    } else {
                                        $record->user->jambAttempts()->create([
                                            'attempts_left' => $jambAttemptsLeft
                                        ]);
                                    }

                                    // Reset course attempts logic
                                    if ($record->user->courses->count() > 0) {
                                        $courses = $record->user->courses;
                                        foreach ($courses as $course) {
                                            $attemptsLeft = is_null($plan->number_of_attempts) ? null : $plan->number_of_attempts;
                                            $record->user->courseAttempts()->updateOrCreate(
                                                ['course_id' => $course->id],
                                                ['attempts_left' => $attemptsLeft]
                                            );
                                        }
                                    }
                                }
                            }
                        });
                    })
                    ->visible(fn (Payment $record): bool => $record->status === 'pending')
                    ->requiresConfirmation('Are you sure you want to update the payment status?')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
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
