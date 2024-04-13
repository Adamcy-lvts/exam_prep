<?php

namespace App\Filament\User\Pages\Auth;

use Exception;
use App\Models\Payment;
use Filament\Pages\Page;
use Filament\Tables\Table;
use App\Models\Subscription;
use Filament\Facades\Filament;
use Filament\Tables\Actions\Action;
use Spatie\Browsershot\Browsershot;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Auth\Authenticatable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Pages\Auth\EditProfile as ProfileEdit;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EditProfile extends ProfileEdit implements HasTable
{
    use InteractsWithTable;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.user.pages.auth.edit-profile';

    public $user;

    public function mount(): void
    {
        $this->fillForm();

        $this->user = $this->getUser();

        // dd($this->user);

    }

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getFirstNameFormComponent(),
                        $this->getLastNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPhoneFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->operation('edit')
                    ->model($this->getUser())
                    ->statePath('data')
                    ->inlineLabel(!static::isSimple()),
            ),
        ];
    }

    protected function getFirstNameFormComponent(): Component
    {
        return TextInput::make('first_name')
            ->label(__('First Name'))
            ->required()
            ->maxLength(255)
            ->autofocus();
    }

    protected function getLastNameFormComponent(): Component
    {
        return TextInput::make('last_name')
            ->label(__('Last Name'))
            ->required()
            ->maxLength(255)
            ->autofocus();
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label(__('filament-panels::pages/auth/edit-profile.form.email.label'))
            ->email()
            ->required()
            ->maxLength(255)
            ->unique(ignoreRecord: true);
    }

    protected function getPhoneFormComponent(): Component
    {
        return TextInput::make('phone')
            ->label(__('Phone'))
            ->maxLength(255);
    }

    public function getUser(): Authenticatable & Model
    {
        $user = Filament::auth()->user();

        if (!$user instanceof Model) {
            throw new Exception('The authenticated user object must be an Eloquent model to allow the profile page to update it.');
        }

        return $user;
    }



    protected function fillForm(): void
    {
        $data = $this->getUser()->attributesToArray();

        $this->callHook('beforeFill');

        $data = $this->mutateFormDataBeforeFill($data);

        $this->form->fill($data);

        $this->callHook('afterFill');
    }


    public function Table(Table $table): Table
    {
        return $table
            ->relationship(fn (): HasMany => $this->user->payments())
            ->inverseRelationship('user')
            ->columns([
                TextColumn::make('plan.title')
                    ->label('Subscription Plan'),
                TextColumn::make('amount')->label('Amount')->money('NGN'),
                TextColumn::make('created_at')->label('Paid On')->dateTime('Y-m-d H:i:s A'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'completed' => 'success',
                    }),
                TextColumn::make('method')->label('Payment Method'),

            ])
            ->filters([
                // ...
            ])
            ->actions([
                Action::make('Download receipt')
                    ->label('Download Receipt')
                    ->action(function (Payment $record, array $data) {
                        $html = view('pdf-receipt-view.payment-receipt', [
                            'payment' => $record,

                        ])->render();
                        // dd($html);
                        $pdfName = $record->user->first_name . '_' . $record->user->last_name . '-' . '_receipt.pdf';
                        $receiptPath = storage_path("app/{$pdfName}");

                        Browsershot::html($html)
                            ->noSandbox()
                            ->setChromePath(config('app.chrome_path'))
                            ->showBackground()
                            ->format('A4')
                            ->save($receiptPath);

                        // Send success notification
                        Notification::make()
                            ->title('Receipt downloaded successfully.')
                            ->success()
                            ->send();

                        return response()->download($receiptPath, $pdfName, [
                            'Content-Type' => 'application/pdf',
                        ])->deleteFileAfterSend(true);
                    })

            ])
            ->bulkActions([
                // ...
            ]);
    }
}
