<?php

namespace App\Filament\Resources;

use Exception;
use Filament\Forms;
use App\Models\Plan;
use Filament\Tables;
use App\Models\Payment;
use App\Models\Receipt;

use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Support\RawJs;
use App\Mail\PaymentReceipt;
use Faker\Provider\ar_EG\Text;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\DB;
use Spatie\LaravelPdf\Facades\Pdf;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Log;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Mail;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
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
                    modifyQueryUsing: fn(Builder $query) => $query->orderBy('first_name')->orderBy('last_name'),
                )
                    ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->first_name} {$record->last_name}")
                    ->searchable(['first_name', 'last_name']),
                TextInput::make('amount')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric(),
                Select::make('plan_id')->relationship(
                    name: 'plan',
                    modifyQueryUsing: fn(Builder $query) => $query->orderBy('title')->orderBy('price'),
                )
                    ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->type} {$record->title} {$record->price}")
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
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'gray',
                        'completed' => 'success',
                    }),
                IconColumn::make('proof_of_payment')
                    ->label('Proof of Payment')
                    ->icon('heroicon-o-document-arrow-down')
                    // ->visible(fn(?Payment $record): bool => $record?->method === 'bank_transfer')
                    // ->visible(fn($record): bool => $record instanceof Payment && $record->method === 'bank_transfer' && $record->proof_of_payment)
                    // ->visible(fn (Payment $record): bool => $record->method === 'bank_transfer')
                    ->action(
                        Action::make('downloadProof')
                            ->label('Download Proof of Payment')
                            ->action(function (Payment $record) {
                                if (!$record->proof_of_payment || !Storage::disk('public')->exists($record->proof_of_payment)) {
                                    Notification::make()
                                        ->title('File not found')
                                        ->danger()
                                        ->send();
                                    return;
                                }

                                return response()->download(
                                    Storage::disk('public')->path($record->proof_of_payment),
                                    basename($record->proof_of_payment)
                                );
                            })
                    ),
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

                            // Generate and save receipt after payment is successful
                            $receipt = $record->receipt()->create([
                                'payment_id' => $record->id,
                                'user_id' => $record->user->id,
                                'payment_date' => now(),
                                'receipt_for' => $record->payment_for, // Assuming 'Subscription' is the type for subscription payments
                                'amount' => $record->amount,
                                'receipt_number' => Receipt::generateReceiptNumber(now()),
                                // 'remarks' and 'qr_code' can be set here if needed
                            ]);


                            try {


                                $pdf = $record->user->first_name . '_' . $record->user->last_name . '-' . '_receipt.pdf';
                                $receiptPath = storage_path("app/{$pdf}");

                                // Generate the PDF receipt
                                Pdf::view('pdf-receipt-view.payment-receipt', [
                                    'payment' => $record,
                                    'receipt' => $receipt
                                ])->withBrowsershot(function (Browsershot $browsershot) {
                                    $browsershot->setChromePath(config('app.chrome_path'));
                                })->save($receiptPath);

                                // Check if the user has an email address
                                if (!empty($record->user->email)) {
                                    // Send the generated receipt to the customer's email
                                    Mail::to($record->user->email)->queue(new PaymentReceipt($record, $receipt, $receiptPath, $pdf));

                                    // Notify the user that the receipt has been sent successfully
                                    Notification::make()
                                        ->title('Receipt sent to the customer\'s email.')
                                        ->success()
                                        ->send();
                                } else {
                                    // Notify the user that the customer doesn't have a valid email
                                    Notification::make()
                                        ->title('Failed to send deposit receipt! Customer does not have an email address.')
                                        ->warning()
                                        ->send();
                                }
                            } catch (\Exception $e) {
                                // Log any exceptions that may arise during this process
                                Log::error("Error sending receipt: {$e->getMessage()}");

                                // Notify the user about the error
                                Notification::make()
                                    ->title('Failed to send deposit receipt! Please try again later or send manually.')
                                    ->danger()
                                    ->send();
                            }
                        });
                    })
                    ->visible(fn(Payment $record): bool => $record->status === 'pending')
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
