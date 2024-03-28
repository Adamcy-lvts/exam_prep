<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\TopicContent;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TopicContentResource\Pages;
use App\Filament\Resources\TopicContentResource\RelationManagers;
use Filament\Tables\Columns\TextColumn;

class TopicContentResource extends Resource
{
    protected static ?string $model = TopicContent::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Content Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Select::make('subject_id')->relationship(name: 'subject', titleAttribute: 'name')->preload(),
                Select::make('topic_id')->relationship(name: 'topic', titleAttribute: 'name')->preload(),
                Textarea::make('description'),
                Textarea::make('learning_objectives'),
                Textarea::make('key_concepts'),
                Textarea::make('real_world_application'),
                RichEditor::make('content')->columnSpan(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('subject.name'),
                TextColumn::make('topic.name'),
                TextColumn::make('description'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListTopicContents::route('/'),
            'create' => Pages\CreateTopicContent::route('/create'),
            'edit' => Pages\EditTopicContent::route('/{record}/edit'),
        ];
    }
}
