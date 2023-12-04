<?php

namespace App\Filament\Resources\QuestionResource\Pages;

use Filament\Actions;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\QuestionResource;

class CreateQuestion extends CreateRecord
{
    protected static string $resource = QuestionResource::class;

    protected function handleRecordCreation(array $data): Model
    {
       

        $question = Question::create([
            'question' => $data['question'],
            'subject_id' => $data['subject_id']
        ]);


        // Loop through each option and create it for the question
        foreach ($data['options'] as $optionData) {

            Option::create([
                'question_id' => $question->id,
                'option'      => $optionData['option'],
                'is_correct'  => $optionData['is_correct'],
            ]);
        }

        return $question;
    }
}
