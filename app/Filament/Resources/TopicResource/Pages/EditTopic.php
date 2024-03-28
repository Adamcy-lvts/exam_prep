<?php

namespace App\Filament\Resources\TopicResource\Pages;

use App\Models\Unit;
use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\TopicResource;

class EditTopic extends EditRecord
{
    protected static string $resource = TopicResource::class;


        // If the record has an associated unit, assign the unit's name to the unit_id field
        // if ($this->record->unit) {
        //     $this->record->unit_id = $this->record->unit->name;
        // }


    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);

        $this->authorizeAccess();

        // If the record has an associated unit, assign the unit's name to the unit_id field
        if ($this->record->unit) {
            $this->record->unit_id = $this->record->unit->name;
        }

        $this->fillForm();

        $this->previousUrl = url()->previous();
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // If unit_id exists in the data, update the Unit and assign its ID to the topic's unit_id column
        if (isset($data['unit_id']) && !empty($data['unit_id'])) {
            $unit = \App\Models\Unit::find($record->unit_id);
            $unit->name = $data['unit_id'];
            $unit->save();
            $data['unit_id'] = $unit->id;
        }

        $record->update($data);

        return $record;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    
}
