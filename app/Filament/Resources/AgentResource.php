<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Agent;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use App\Helpers\PaystackHelper;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use App\Jobs\CreatePaystackSubaccount;
use App\Models\SchoolRegistrationLink;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rules\Password;
use Unicodeveloper\Paystack\Facades\Paystack;
use App\Filament\Resources\AgentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AgentResource\RelationManagers;

class AgentResource extends Resource
{
    protected static ?string $model = Agent::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('first_name')->label('First Name'),
                TextInput::make('last_name')->label('Last name'),
                TextInput::make('business_name')
                    ->required()
                    ->label('Business Name'),
                TextInput::make('account_number')
                    ->numeric()
                    ->required()
                    ->label('Account Number'),
                TextInput::make('account_name')
                    ->required()
                    ->label('Account Name'),
                Select::make('bank_id')
                    ->relationship('bank', 'name')
                    ->required()
                    ->label('Bank'),
                TextInput::make('email')->label('Email'),
                TextInput::make('phone')->label('Phone'),
                TextInput::make('referral_code')
                    ->disabled()
                    ->label('Referral Code'),
                TextInput::make('subaccount_code')
                    ->label('Subaccount Code'),
                TextInput::make('percentage')
                    ->numeric()
                    ->suffix('%')
                    ->label('Commission Rate (%)'),
                TextInput::make('fixed_rate')
                    ->numeric()
                    ->suffix('%')
                    ->label('Fixed Rate Commission'),
                TextInput::make('password')
                    ->label(__('Password'))
                    ->password()
                    ->rule(Password::default())
                    ->dehydrateStateUsing(fn($state) => Hash::make($state))
                    ->same('passwordConfirmation')
                    ->validationAttribute(__('filament-panels::pages/auth/register.form.password.validation_attribute')),
                TextInput::make('passwordConfirmation')
                    ->label(__('Password'))
                    ->password()

                    ->dehydrated(false)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.full_name')
                    ->label('Full Name'),
                TextColumn::make('business_name')
                    ->label('Business Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('is_school')
                    ->badge()
                    ->label('Agent Type')

                    ->getStateUsing(fn($record) => $record->is_school ? 'School' : 'Individual')
                    ->colors([
                        'primary' => 'Individual',
                        'success' => 'School',
                    ]),
                TextColumn::make('account_number')
                    ->label('Account Number')
                    ->sortable(),
                TextColumn::make('user.phone')
                    ->label('Phone'),
                TextColumn::make('referral_code')
                    ->label('Referral Code'),
                TextColumn::make('subaccount_code')
                    ->label('Subaccount Code'),
                TextColumn::make('referredUsers')
                    ->label('Referred Users')
                    ->getStateUsing(fn($record) => $record->referredUsers()->count()),
                TextColumn::make('percentage')
                    ->label('Commission Rate (%)')
                    ->sortable(),
                TextColumn::make('fixed_rate')
                    ->label('Fixed Rate Commission')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Joined At')
                    ->dateTime('d-m-Y')
                    ->sortable(),
            ])
            ->filters([
                Filter::make('is_school')
                    ->label('Agent Type')
                    ->form([
                        Forms\Components\Select::make('is_school')
                            ->label('Agent Type')
                            ->options([
                                0 => 'Individual',
                                1 => 'School',
                            ])
                            ->placeholder('All Types'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['is_school'] !== null,
                            fn(Builder $query, $is_school): Builder => $query->where('is_school', $is_school)
                        );
                    }),
                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('createSubaccount')
                    ->label('Create Subaccount')
                    ->action(function ($record) {
                        try {
                            // dd($record->business_name);
                            // Prepare subaccount data
                            $subaccountData = [
                                'business_name' => $record->business_name,
                                'settlement_bank' => $record->bank->code, // Ensure the bank has a 'code' field
                                'account_number' => $record->account_number,
                                'percentage_charge' => $record->percentage, // Ensure this field exists on your model
                                'primary_contact_email' => $record->user->email,
                            ];
                            // dd($subaccountData);
                            // Attempt to create a subaccount on Paystack
                            $subaccount = PaystackHelper::createSubAccount($subaccountData);
                            // Paystack::createSubAccount($subaccountData);

                            // Check if the creation was successful
                            if (isset($subaccount['status']) && $subaccount['status']) {
                                // Update the agent's subaccount code
                                $record->update(['subaccount_code' => $subaccount['data']['subaccount_code']]);

                                // Notify the user of success
                                Notification::make()
                                    ->title('Subaccount Created')
                                    ->body('The subaccount has been successfully created.')
                                    ->success()
                                    ->send();
                            } else {
                                // Notify the user of failure
                                Notification::make()
                                    ->title('Subaccount Creation Failed')
                                    ->body('Failed to create the subaccount. Please try again.')
                                    ->danger()
                                    ->send();
                            }
                        } catch (\Exception $e) {
                            // Log the error and notify the user
                            Log::error('Failed to create Paystack subaccount: ' . $e->getMessage());

                            Notification::make()
                                ->title('Subaccount Creation Failed')
                                ->body('An error occurred while creating the subaccount. Please contact support.')
                                ->danger()
                                ->send();
                        }
                    })
                    ->visible(fn($record) => empty($record->subaccount_code))
                    ->icon('heroicon-o-plus')
                    ->color('success'),
                Action::make('generateSchoolLink')
                    ->label('Generate School Link')
                    ->icon('heroicon-o-link')
                    ->color('secondary')
                    ->action(function (Agent $record) {
                        $link = SchoolRegistrationLink::create([
                            'agent_id' => $record->id,
                            'token' => Str::random(32),
                            'expires_at' => now()->addDays(7), // Link expires in 7 days
                        ]);

                        $fullLink = route('school.register', ['token' => $link->token]);

                        Notification::make()
                            ->title('School Registration Link Generated')
                            ->body("Link: {$fullLink}")
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation(),
                Tables\Actions\DeleteAction::make(),
                // Action::make('delete')
                //     ->requiresConfirmation()
                //     ->action(fn (Agent $record) => $record->delete())
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
            'index' => Pages\ListAgents::route('/'),
            'create' => Pages\CreateAgent::route('/create'),
            'edit' => Pages\EditAgent::route('/{record}/edit'),
        ];
    }
}
