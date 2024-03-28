<?php

namespace App\Filament\User\Resources\SubjectResource\Pages;

use Carbon\Carbon;
use App\Models\Topic;
use App\Models\Option;
use App\Models\Subject;
use App\Models\Question;
use App\Models\QuizAnswer;
use Livewire\Attributes\On;
use App\Models\SubjectTopic;
use Livewire\WithPagination;
use App\Models\TopicQuizAttempt;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\TopicQuizTimeTracking;
use App\Filament\User\Resources\SubjectResource;

class SubjectLessonPage extends Page
{
    use WithPagination;

    protected static string $resource = SubjectResource::class;

    protected static string $view = 'filament.user.resources.subject-resource.pages.subject-lesson-page';

    public $answers = [];
    public $subject;
    public $examId;
    public $exam;
    public $fieldID;
    public $topics;
    public $selectedTopicId = null;

    public $remainingTime;
    public $remainingTimeInSeconds;

    public $clickedTopic;
    public $previousTopicName;
    public $showQuizInstructions = true;
    public $previousTopicId;
    public $showConfirmationModal = false;

    public $currentTopicId;
    public $showQuiz = false;

    public $showAI = false;

    public $questionIds = [];
    public $currentQuestionIndex = 0;
    public $currentQuestion = null;
    public $currentOptions = [];

    public $currentAttemptId;
    public $topicId;

    public $currentAttempt;

    public $userTopics;
    public $unlockedTopics;

    public $timeLeftForCurrentQuestion;

    // protected $listeners = ['open-modal' => 'handleOpenModal'];

    function mount($subjectId)
    {

        $this->subject = Subject::with(['topics.content'])->find($subjectId);

        $this->unlockedTopics = auth()->user()->topics()->wherePivot('unlocked', true)->pluck('topic_id');
        // $previousTopicPassed = true; // Assuming the first topic is always unlocked.

        // Unlock the first topic by default
        $this->unlockFirstTopicForUser(auth()->id(), $this->subject->topics->first()->id);

        // dd($this->subject->topics);
        $this->exam = $this->subject->exam;
    }


  

    public function isTopicUnlocked($topicId)
    {
        // Check if the topic ID exists in the unlocked topics collection.
        return $this->unlockedTopics->contains($topicId);
    }

    public function unlockFirstTopicForUser($userId, $firstTopicId)
    {
        // Check if the entry exists first to avoid duplicates
        $existingEntry = DB::table('topic_users')->where('user_id', $userId)->where('topic_id', $firstTopicId)->exists();

        if (!$existingEntry) {
            DB::table('topic_users')->insert([
                'user_id' => $userId,
                'topic_id' => $firstTopicId,
                'unlocked' => true, // Unlock the first topic
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }




    // #[On('open-modal')]
    public function handleOpenModal($topicId)
    {


        $this->clickedTopic = Topic::findOrFail($topicId);
        $previousTopic = Topic::where('order', '<', $this->clickedTopic->order)
            ->orderBy('order', 'desc')
            ->first();

        // If there's a previous topic, update the property that holds its name.
        // Otherwise, set it to null or a default message.
        $this->previousTopicId = $previousTopic ? $previousTopic->id : null;
        $this->previousTopicName = $previousTopic ? $previousTopic->name : null;

        $this->dispatch('open-modal', id: 'quiz-instructions-modal');
    }

    public function startQuiz($topicId)
    {
        $this->dispatch('startQuiz', $topicId);
    }

    public function unlockNextTopic($userId, $currentTopicId)
    {

        $nextTopic = $this->subject->topics
            ->where('order', '>', $this->currentAttempt->topic->order)
            ->first();

        if ($nextTopic) {
            // Update the unlocked status in the database
            DB::table('topic_users')->updateOrInsert(
                ['user_id' => $userId, 'topic_id' => $nextTopic->id],
                ['unlocked' => true]
            );

            // Update the unlocked status in the component state
            $nextTopicKey = $this->subject->topics->search(function ($topic) use ($nextTopic) {
                return $topic->id === $nextTopic->id;
            });

            if ($nextTopicKey !== false) {
                $this->subject->topics[$nextTopicKey]->unlocked = true;
            }

            // Notify the frontend to update the UI
            $this->dispatch('topicUnlocked', $nextTopic->id);
        }
    }


    #[On('topicUnlocked')]
    public function updateTopicUnlockedStatus($topicId)
    {
       
        $this->unlockedTopics = auth()->user()->topics()->where('unlocked', true)->pluck('topic_id');
    }
}
