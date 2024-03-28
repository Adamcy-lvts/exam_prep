<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use App\Models\Plan;
use App\Models\User;
use Filament\Tables;
use App\Models\Course;
use App\Models\Subject;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'User & Subscription Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('first_name')->label('First Name'),
                TextInput::make('last_name')->label('Last Name'),
                TextInput::make('email')->label('Email'),
                TextInput::make('phone')->label('Phone'),
                TextInput::make('password')->password()
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->revealable(),
                Select::make('exam_id')->relationship(name: 'exam', titleAttribute: 'exam_name')->label('Exam'),
                Checkbox::make('is_on_trial'),
                DatePicker::make('trial_ends_at'),
                Select::make('subjects')->options(Subject::all()->pluck('name', 'id'))->searchable()->multiple(),
                Select::make('courses')->options(Course::all()->pluck('title', 'id'))->searchable()->multiple(),
                Select::make('plan')->label('Plan')->options(Plan::all()->pluck('title', 'id'))->searchable(),
                // Using Select Component
                Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),

              
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')->label('Full Name')->searchable('first_name'),
                TextColumn::make('email')->copyable()->searchable(),
                TextColumn::make('phone')->copyable()->searchable()->default('NULL'),
                TextColumn::make('exam.exam_name')->label('Registered Exam')->default('No Registered Exam'),
                TextColumn::make('subscriptions.status')
                    ->getStateUsing(fn (Model $record) => $record->subscriptions()->latest()->first()?->status ?? 'no subscription')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {

                        'active' => 'success',
                        'expired' => 'danger',
                        'cancelled' => 'warning',
                        'no subscription' => 'info',
                    })->label('Subscription Status'),

                TextColumn::make('created_at')->label('Registered On')->dateTime('d-m-Y H:i:s A'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('subscribe')
                    ->url(fn (User $record): string => route('filament.admin.resources.users.subscribe', $record))

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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'subscribe' => Pages\Subscribe::route('/{record}/subscribe'),
        ];
    }
}
