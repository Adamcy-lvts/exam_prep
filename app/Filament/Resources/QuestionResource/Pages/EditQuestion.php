<?php

namespace App\Filament\Resources\QuestionResource\Pages;

use App\Filament\Resources\QuestionResource;
use App\Models\Question;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditQuestion extends EditRecord
{
    protected static string $resource = QuestionResource::class;

    // Define properties for fields that need special handling
    public $type;
    public $answer_text;
    public $options = [];

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function mount($record): void
    {
        parent::mount($record);

        $this->form->fill($this->record->attributesToArray());
// dd($this->record->answer_text);
        $this->type = $this->record->type;

        if ($this->record->type === Question::TYPE_MCQ) {
            $this->options = $this->record->options->map(function ($option) {
                return [
                    'option' => $option->option,
                    'is_correct' => $option->is_correct,
                ];
            })->toArray();
        } else {
            $this->answer_text = $this->record->answer_text;
        }
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->fill($data);

        if ($record->type === Question::TYPE_MCQ) {
            $record->answer_text = null; // Clear answer_text for MCQ
            $record->save();

            // Update or create options for MCQ
            foreach ($this->options as $optionData) {
                $record->options()->updateOrCreate(
                    ['option' => $optionData['option']],
                    ['is_correct' => $optionData['is_correct']]
                );
            }
            // Remove any options not in the submitted data
            $record->options()->whereNotIn('option', collect($this->options)->pluck('option'))->delete();
        } else {
            $record->answer_text = $this->answer_text;
            $record->options()->delete(); // Remove any existing options for non-MCQ questions
            $record->save();
        }

        return $record;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
