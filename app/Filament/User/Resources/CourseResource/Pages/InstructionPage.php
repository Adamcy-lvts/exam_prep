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

    public $selectedNumberOfQuestions = 20;



    public function startQuiz()
    {
        // Save the current settings for number of questions and duration to the session.
        session([
            'selectedNumberOfQuestions' => $this->selectedNumberOfQuestions,
            'selectedDuration' => $this->duration,
        ]);

        // If the user has an active unlimited plan, proceed to the quiz.
        if ($this->user->hasFeature('Unlimited Quiz Attempts for 30 days')) {
            $this->proceedToQuiz();
            return;
        }

        // Check for subject attempts for the specific quiz.
        if ($this->user->hasCourseAttempts($this->quizzable->quizzable_id)) {
            $this->proceedToQuiz();
            return;
        }

        // Check if the user has any Jamb attempts left.

        if ($this->user->hasCourseAttemptsForAnyCourse()) {
            // Inform the user they have attempts left for other subjects but not for this specific quiz.
            Notification::make()
                ->title("You have no attempts left for this course.")
                ->body("You have attempts left for other courses. Please select another course to continue.")
                ->warning()
                ->send();
            return redirect()->route('filament.user.pages.dashboard');
        } else {
            // The user has no attempts left for any subject or Jamb, redirect to the pricing page.
            Notification::make()
                ->title("You have exhausted all your attempts.")
                ->body("Please purchase more attempts to continue.")
                ->warning()
                ->send();
            return redirect()->route('filament.user.resources.course.pricing-page');
        }


        // if (!$this->user->hasCourseAttempts($this->quizzable->quizzable_id)) {

        //     Notification::make()->title("You have exhausted your all your attempts, Please Purchase another attempts.")
        //     ->warning()
        //         ->send();
        //     return redirect()->route('filament.user.resources.courses.pricing-page');
        // }


        // If checks pass,close any confirmation modal and proceed to the quiz questions page.
        $this->showConfirmationModal = false;

        // Redirect to the quiz questions page with the necessary parameters.
        // return redirect()->route('filament.user.resources.courses.questions', [
        //     'record' => $this->quizzable->id,
        //     'quizzableType' => $this->quizzable->quizzable_type
        // ]);
    }

    protected function proceedToQuiz()
    {
        $this->showConfirmationModal = false;
        return redirect()->route('filament.user.resources.courses.questions', [
            'record' => $this->quizzable->id,
            'quizzableType' => $this->quizzable->quizzable_type
        ]);
    }

    public function continueLastAttempt()
    {
        if (auth()->check()) {
            // Check if there's an ongoing attempt for the current user
            $ongoingAttempt = QuizAttempt::where('user_id', auth()->user()->id)
                ->where('quiz_id', $this->quizzable->id)
                ->whereNull('end_time')
                ->first();

            if ($ongoingAttempt) {
                // Get the last answered question's ID
                $lastAnsweredQuestionId = QuizAnswer::where('user_id', auth()->user()->id)
                    ->where('quiz_attempt_id', $ongoingAttempt->id)
                    ->latest('created_at')
                    ->value('question_id');

                // Get all question IDs for the quiz in the correct order
                // $questionIds = $this->ongoingAttempt->questions()->orderBy('id')->pluck('id')->toArray();
                $questionIds = $this->ongoingAttempt->questions()
                    ->orderBy('questions.id') // Specify the table name before the column name
                    ->pluck('questions.id') // Again, specify the table name
                    ->toArray();

                // Find the index of the last answered question
                $lastAnsweredIndex = array_search($lastAnsweredQuestionId, $questionIds);

                // Assuming 5 questions per page
                $questionsPerPage = 5;
                // Calculate the page number based on index
                // $pageNumber = ceil(($lastAnsweredIndex + 1) / $questionsPerPage);

                $pageNumber = ceil(($lastAnsweredIndex + 1) / $questionsPerPage);

                // Ensure the pageNumber is within the valid range of pages
                $maxPageNumber = ceil(count($questionIds) / $questionsPerPage);
                $pageNumber = max(1, min($pageNumber, $maxPageNumber));

                // Redirect to the correct page
                return redirect()->route('filament.user.resources.subjects.questions', [
                    'record' => $this->quizzable->id,
                    'quizzableType' => $this->quizzable->quizzable_type,
                    'page' => $pageNumber
                ]);
            }
        }

        // If there's no ongoing attempt, redirect to the first page
        return redirect()->route('filament.user.resources.subjects.questions', [
            'record' => $this->quizzable->id,
            'quizzableType' => $this->quizzable->quizzable_type,
            'page' => 1
        ]);
    }

    // public function continueLastAttempt()
    // {


    //     // Redirecting the user based on the last answered question
    //     if (auth()->check()) {
    //         // Determine the total number of questions for the quiz
    //         $totalQuestions = $this->quizzable->questions()->count();

    //         // Assuming 5 questions per page
    //         $questionsPerPage = 5;
    //         $maxPageNumber = ceil($totalQuestions / $questionsPerPage);

    //         // Check if there's an ongoing attempt for the current user
    //         $ongoingAttempt = QuizAttempt::where('user_id', auth()->user()->id)
    //             ->where('quiz_id', $this->quizzable->id)
    //             ->whereNull('end_time') // assuming 'end_time' is set when the quiz is submitted.
    //             ->first();

    //         // If there's an ongoing attempt

    //         if ($ongoingAttempt) {
    //             // dd($ongoingAttempt);
    //             $lastAnsweredQuestion = QuizAnswer::where('user_id', auth()->user()->id)
    //                 ->where('quiz_attempt_id', $ongoingAttempt->id)
    //                 ->latest('created_at')
    //                 ->first();
    //             // dd($lastAnsweredQuestion);
    //             // If the user has answered any questions in the ongoing attempt
    //             if ($lastAnsweredQuestion) {
    //                 $pageNumber = ceil($lastAnsweredQuestion->question_id / $questionsPerPage);

    //                 // Ensure the pageNumber doesn't exceed the maxPageNumber
    //                 $pageNumber = min($pageNumber, $maxPageNumber);

    //                 // Check if the current page is different from the page the user should be on
    //                 if ($this->getPage() != $pageNumber) {
    //                     // Redirect to the correct page
    //                     return redirect()->route('filament.user.resources.courses.questions', [
    //                         'record' => $this->quizzable->id,
    //                         'quizzableType' => $this->quizzable->quizzable_type, 
    //                         'page' => $pageNumber
    //                     ]);
    //                 }
    //             }
    //         } else {
    //             // If there's no ongoing attempt, always redirect to the first page
    //             if ($this->getPage() != 1) {
    //                 return redirect()->route('filament.user.resources.courses.questions', [
    //                     'record' => $this->quizzable->id,
    //                     'quizzableType' => $this->quizzable->quizzable_type, 'page' => 1
    //                 ]);
    //             }
    //         }
    //     }
    //     return redirect()->route('filament.user.resources.courses.questions', [
    //         'record' => $this->quizzable->id,
    //         'quizzableType' => $this->quizzable->quizzable_type
    //     ]);
    // }
}
