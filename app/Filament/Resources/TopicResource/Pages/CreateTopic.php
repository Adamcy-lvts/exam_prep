<?php

namespace App\Filament\Resources\TopicResource\Pages;

use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\TopicResource;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Unit;

class CreateTopic extends CreateRecord
{
    protected static string $resource = TopicResource::class;


    protected function handleRecordCreation(array $data): Model
    {
        $record = new ($this->getModel())($data);

        // If unit_id exists in the data, create a Unit and assign its ID to the topic's unit_id column
        if (isset($data['unit_id']) && !empty($data['unit_id'])) {
            $unit = Unit::create(['name' => $data['unit_id']]);
            $record->unit_id = $unit->id;
        }

        $record->save();

        return $record;
    }
}
