<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use App\Models\Plan;
use App\Models\User;
use Filament\Tables;
use App\Models\Course;
use App\Models\Subject;
use App\Helpers\Options;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\UserResource\Pages;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'User & Subscription Management';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        TextInput::make('first_name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('last_name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(User::class, 'email', ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->tel()
                            ->maxLength(20),
                        TextInput::make('password')
                            ->password()
                            ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                            ->dehydrated(fn(?string $state): bool => filled($state))
                            ->required(fn(string $context): bool => $context === 'create')
                            ->maxLength(255)
                            ->revealable(),
                    ])->columns(2),

                Forms\Components\Section::make('User Details')
                    ->schema([
                        Select::make('exam_id')
                            ->relationship('exam', 'exam_name')
                            ->searchable()
                            ->preload(),
                        Select::make('user_type')
                            ->options(Options::userTypes())
                            ->required(),
                        Select::make('status')
                            ->options(Options::userStatus())
                            ->required()
                            ->default('Active'),
                    ])->columns(3),

                Forms\Components\Section::make('Subscription & Trial')
                    ->schema([
                        Checkbox::make('is_on_trial'),
                        DateTimePicker::make('trial_ends_at')
                            ->label('Trial End Date'),
                        Select::make('plan')
                            ->relationship('subscriptions', 'plan_id')
                            ->getOptionLabelFromRecordUsing(fn(Model $record) => Plan::find($record->plan_id)->title)
                            ->searchable(),
                    ])->columns(3),

                Forms\Components\Section::make('Permissions')
                    ->schema([
                        Select::make('roles')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable(),
                    ]),

                Forms\Components\Section::make('Courses & Subjects')
                    ->schema([
                        Select::make('subjects')
                            ->relationship('subjects', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload(),
                        Select::make('courses')
                            ->relationship('courses', 'title')
                            ->multiple()
                            ->searchable()
                            ->preload(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label('Full Name')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(),
                TextColumn::make('email')
                    ->copyable()
                    ->sortable()
                    ->searchable(),
                TextColumn::make('phone')
                    ->copyable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('user_type')
                    ->badge()
                    ->colors([
                        'primary' => 'student',
                        'success' => 'agent',
                        'warning' => 'admin',
                    ]),
                TextColumn::make('exam.exam_name')
                    ->label('Registered Exam')
                    ->default('No Registered Exam')
                    ->searchable(),
                TextColumn::make('subscriptions.status')
                    ->badge()
                    ->label('Subscription Status')
                    ->getStateUsing(fn(Model $record) => $record->subscriptions()->latest()->first()?->status ?? 'no subscription')
                    ->colors([
                        'success' => 'active',
                        'danger' => ['expired', 'cancelled'],
                        'warning' => 'pending',
                        'secondary' => 'no subscription',
                    ]),
                IconColumn::make('is_on_trial')
                    ->boolean()
                    ->label('On Trial')
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-mark')
                    ->toggleable(),
                TextColumn::make('trial_ends_at')
                    ->label('Trial Ends')
                    ->date('d M Y')
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Registered On')
                    ->dateTime('d M Y, H:i A')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_type')
                    ->options(Options::userTypes()),
                Tables\Filters\SelectFilter::make('status')
                    ->options(Options::userStatus()),
                Tables\Filters\Filter::make('is_on_trial')
                    ->query(fn(Builder $query): Builder => $query->where('is_on_trial', true)),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
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
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('subscribe')
                    ->url(fn(User $record): string => route('filament.admin.resources.users.subscribe', $record))
                    ->icon('heroicon-o-credit-card')
                    ->tooltip('Manage Subscription'),
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
            // RelationManagers\SubscriptionsRelationManager::class,
            // RelationManagers\PaymentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'subscribe' => Pages\Subscribe::route('/{record}/subscribe'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['first_name', 'last_name', 'email', 'phone'];
    }
}
