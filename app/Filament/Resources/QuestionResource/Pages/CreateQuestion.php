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

        $existingQuestion = Question::where([
            'quiz_id' => $data['quiz_id'],
            'quizzable_type' => $data['quizzable_type'],
            'quizzable_id' => $data['quizzable_id'],
            'topic_id' => $data['topic_id'],
            'question' => $data['question'],
            'type' => $data['type'],
        ])->first();

        if ($existingQuestion) {
            // If a question with the same attributes already exists, return it
            return $existingQuestion;
        }

        $question = Question::create([
            'quiz_id' => $data['quiz_id'],
            'quizzable_type' => $data['quizzable_type'],
            'quizzable_id' => $data['quizzable_id'],
            'topic_id' => $data['topic_id'],
            'duration' => $data['duration'],
            'question' => $data['question'],
            'type' => $data['type'],
            'answer_text' => $data['answer_text'],
            'explanation' => $data['explanation'],
            'marks' => $data['marks'],
        ]);

        // Loop through each option and create it for the question
        foreach ($data['options'] as $optionData) {
            Option::create([
                'question_id' => $question->id,
                'option' => $optionData['option'],
                'is_correct' => $optionData['is_correct'],
            ]);
        }

        return $question;
    }
}
