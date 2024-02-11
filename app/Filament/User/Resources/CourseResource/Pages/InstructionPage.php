<?php

namespace App\Filament\User\Resources\CourseResource\Pages;

use Exception;
use App\Models\Quiz;
use App\Models\Course;
use App\Models\Subject;
use App\Models\QuizAnswer;
use App\Models\QuizAttempt;
use App\Models\QuizSession;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Log;
use Filament\Notifications\Notification;
use App\Filament\Traits\InstructionPageTrait;
use App\Filament\User\Resources\CourseResource;

class InstructionPage extends Page
{

    use InstructionPageTrait;
    
    protected static string $resource = CourseResource::class;

    protected static string $view = 'filament.user.resources.course-resource.pages.instruction-page';

    public $selectedNumberOfQuestions = 100;

    public function startQuiz()
    {
        // Save the current settings for number of questions and duration to the session.
        session([
            'selectedNumberOfQuestions' => $this->selectedNumberOfQuestions,
            'selectedDuration' => $this->duration,
        ]);

        if (!$this->user->hasCourseAttempts($this->quizzable->quizzable_id)) {

            Notification::make()->title("You have exhausted your all your attempts, Please Purchase another attempts.")
            ->warning()
                ->send();
            return redirect()->route('filament.user.resources.courses.pricing-page');
        }
        

        // If checks pass,close any confirmation modal and proceed to the quiz questions page.
        $this->showConfirmationModal = false;

        // Redirect to the quiz questions page with the necessary parameters.
        return redirect()->route('filament.user.resources.courses.questions', [
            'record' => $this->quizzable->quizzable_id,
            'quizzableType' => $this->quizzable->quizzable_type
        ]);
    }

    public function continueLastAttempt()
    {


        // Redirecting the user based on the last answered question
        if (auth()->check()) {
            // Determine the total number of questions for the quiz
            $totalQuestions = $this->quizzable->questions()->count();

            // Assuming 5 questions per page
            $questionsPerPage = 5;
            $maxPageNumber = ceil($totalQuestions / $questionsPerPage);

            // Check if there's an ongoing attempt for the current user
            $ongoingAttempt = QuizAttempt::where('user_id', auth()->user()->id)
                ->where('quiz_id', $this->quizzable->id)
                ->whereNull('end_time') // assuming 'end_time' is set when the quiz is submitted.
                ->first();

            // If there's an ongoing attempt
            if ($ongoingAttempt) {
                $lastAnsweredQuestion = QuizAnswer::where('user_id', auth()->user()->id)
                    ->where('quiz_attempt_id', $ongoingAttempt->id)
                    ->latest('created_at')
                    ->first();

                // If the user has answered any questions in the ongoing attempt
                if ($lastAnsweredQuestion) {
                    $pageNumber = ceil($lastAnsweredQuestion->question_id / $questionsPerPage);

                    // Ensure the pageNumber doesn't exceed the maxPageNumber
                    $pageNumber = min($pageNumber, $maxPageNumber);

                    // Check if the current page is different from the page the user should be on
                    if ($this->getPage() != $pageNumber) {
                        // Redirect to the correct page
                        return redirect()->route('filament.user.resources.courses.questions', [
                            'record' => $this->quizzable->id,
                            'quizzableType' => $this->quizzable->quizzable_type, 'page' => $pageNumber
                        ]);
                    }
                }
            } else {
                // If there's no ongoing attempt, always redirect to the first page
                if ($this->getPage() != 1) {
                    return redirect()->route('filament.user.resources.courses.questions', [
                        'record' => $this->quizzable->id,
                        'quizzableType' => $this->quizzable->quizzable_type, 'page' => 1
                    ]);
                }
            }
        }
        return redirect()->route('filament.user.resources.courses.questions', [
            'record' => $this->quizzable->id,
            'quizzableType' => $this->quizzable->quizzable_type
        ]);
    }


}
