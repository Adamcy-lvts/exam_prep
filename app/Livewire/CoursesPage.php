<?php

namespace App\Livewire;

use App\Models\Plan;
use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Filament\Notifications\Notification;

class CoursesPage extends Component
{
    use WithPagination;

    // public $courses;
    public $selectedCourses = [];
    public $examId;
    public $search = '';

    public function mount($examId = null)
    {

        // check if user is registered
        // dd($examId);
        $this->examId = $examId;
        $user = auth()->user();
        if ($user->registration_status === \App\Models\User::STATUS_REGISTRATION_COMPLETED) {
            return redirect()->route('filament.user.pages.dashboard');
        }

        // if($faculty_id){
        //     $this->courses = Course::where('faculty_id', $faculty_id)->get();
        // }else{
            // $this->courses = Course::all();

            // dd($this->courses);
        // }
        // dd($this->courses);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleCourse($courseId)
    {
        if (in_array($courseId, $this->selectedCourses)) {
            $this->selectedCourses = array_diff($this->selectedCourses, [$courseId]);
        } else {
            $this->selectedCourses[] = $courseId;
        }
    }

    public function registerCourses()
    {
        if (count($this->selectedCourses) < 1) {
            Notification::make()
                ->title('Please select at least one course')
                ->info()
                ->send();
            return  redirect()->route('courses.page', ['examid' => $this->examId]);

            return redirect()->route('courses.page');
        }

        // Retrieve the Basic Access Plan, if it doesn't exist, log an error or handle it accordingly.
        $basicPlan = Plan::where('title', 'Free Access Plan')->first();

        $user = auth()->user();

        // Assign the noun_student role to the user
        $user->assignRole('noun_student');

        if ($basicPlan) {
            // Create a subscription for the basic plan. Since it's a free plan, you might not set an expiration date,
            // or set a very distant future date if you want to enforce checking subscription validity.
            $user->subscriptions()->create([
                'plan_id' => $basicPlan->id,
                'starts_at' => now(),
                'ends_at' => now()->addYears(10), // Optional: for a free plan, you might not need an expiration.
                'status' => 'active', // Consider your logic for setting status
                'features' => $basicPlan->features // Copying features from plan to subscription
            ]);
        } else {
            // Log error or handle the situation where the Free Access Plan doesn't exist.
            Log::error('Free Access Plan not found during user registration.', ['user_id' => $user->id]);
        }

        if (!$basicPlan) {
            return redirect()->back()->withErrors('Free Access Plan not found.');
        }

        $user = auth()->user();
        $user->courses()->detach();
        $user->courses()->attach($this->selectedCourses);
        $user->exam_id = $this->examId;
        $user->registration_status = \App\Models\User::STATUS_REGISTRATION_COMPLETED;
        $user->save();

        if (!$user->hasInitializedCourseAttempts()) {
            foreach ($user->courses as $course) {
                $user->courseAttempts()->create([
                    'course_id' => $course->id,
                    'attempts_left' => $basicPlan->number_of_attempts ?? 1,
                ]);
            }
            $user->markCourseAttemptsAsInitialized();
        }

    
        Notification::make()
            ->title('Your courses have been registered successfully.')
            ->success()
            ->send();

        return redirect()->route('filament.user.pages.dashboard');
    }

    public function render()
    {
        $courses = Course::where('is_visible', true)
            ->where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('course_code', 'like', '%' . $this->search . '%');
            })
            ->paginate(12);

        return view('livewire.courses-page', [
            'courses' => $courses,
        ]);
    }
}
