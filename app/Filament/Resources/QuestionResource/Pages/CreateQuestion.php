<?php

namespace App\Filament\Resources\QuestionResource\Pages;

use App\Models\Option;
use App\Models\Question;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\QuestionResource;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;

class CreateQuestion extends CreateRecord
{
    protected static string $resource = QuestionResource::class;

    protected bool $isExistingQuestion = false;

    protected function handleRecordCreation(array $data): Model
    {
        // Check for existing question
        $existingQuestion = Question::where([
            'quiz_id' => $data['quiz_id'],
            'quizzable_type' => $data['quizzable_type'],
            'quizzable_id' => $data['quizzable_id'],
            'question' => $data['question'],
            'type' => $data['type'],
        ])->first();

        if ($existingQuestion) {
            $this->isExistingQuestion = true;
            return $existingQuestion;
        }

        // Create the question if it doesn't exist
        $question = Question::create([
            'quiz_id' => $data['quiz_id'],
            'quizzable_type' => $data['quizzable_type'],
            'quizzable_id' => $data['quizzable_id'],
            'topic_id' => $data['topic_id'],
            'duration' => $data['duration'],
            'question' => $data['question'],
            'type' => $data['type'],
            'marks' => $data['marks'],
            'explanation' => $data['explanation'] ?? null,
            'question_image' => $data['question_image'] ?? null, // Handle the uploaded image
        ]);

        // Handle different question types
        switch ($data['type']) {
            case Question::TYPE_MCQ:
                if (isset($data['options']) && is_array($data['options'])) {
                    $this->createMCQOptions($question, $data['options']);
                }
                break;
            case Question::TYPE_SAQ:
            case Question::TYPE_TF:
                $question->update(['answer_text' => $data['answer_text'] ?? null]);
                break;
        }

        return $question;
    }

    protected function createMCQOptions(Question $question, array $options): void
    {
        foreach ($options as $optionData) {
            if (!empty($optionData['option'])) {
                Option::updateOrCreate(
                    [
                        'question_id' => $question->id,
                        'option' => $optionData['option'],
                    ],
                    [
                        'is_correct' => $optionData['is_correct'] ?? false,
                    ]
                );
            }
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        if ($this->isExistingQuestion) {
            return Notification::make()
                ->warning()
                ->title('Question already exists')
                ->body('A similar question already exists in the database.');
        }

        return Notification::make()
            ->success()
            ->title('Question created')
            ->body('The question has been created successfully.');
    }

    // Override the afterCreate method to prevent the default notification
    protected function afterCreate(): void
    {
        // Do nothing here to prevent the default notification
    }
}