<?php

namespace App\Livewire;

use App\Models\Plan;
use App\Models\User;
use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Filament\Notifications\Notification;

class CoursesPage extends Component
{
    use WithPagination;

    public $selectedCourses = [];
    public $examId;
    public $search = '';
    public $user;

    public function mount($examId = null)
    {
        $this->user = User::find(auth()->id());
        
        $this->examId = $examId;
        $user = auth()->user();
        if ($user->registration_status === \App\Models\User::STATUS_REGISTRATION_COMPLETED) {
            return redirect()->route('filament.user.pages.dashboard');
        }
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

    // public function registerCourses()
    // {
    //     if (count($this->selectedCourses) < 1) {
    //         Notification::make()
    //             ->title('Please select at least one course')
    //             ->info()
    //             ->send();
    //         return redirect()->route('courses.page', ['examid' => $this->examId]);
    //     }

    //     $basicPlan = Plan::where('title', 'Free Plan')->first();

    //     $user = auth()->user();
    //     $user->assignRole('noun_student');

    //     if ($basicPlan) {
    //         $user->subscriptions()->create([
    //             'plan_id' => $basicPlan->id,
    //             'starts_at' => now(),
    //             'ends_at' => now()->addYears(10),
    //             'status' => 'active',
    //             'features' => $basicPlan->features
    //         ]);
    //     } else {
    //         Log::error('Free Plan not found during user registration.', ['user_id' => $user->id]);
    //         return redirect()->back()->withErrors('Free Plan not found.');
    //     }

    //     $user->courses()->detach();
    //     $user->courses()->attach($this->selectedCourses);
    //     $user->exam_id = $this->examId;
    //     $user->registration_status = \App\Models\User::STATUS_REGISTRATION_COMPLETED;
    //     $user->save();

    //     if (!$user->hasInitializedCourseAttempts()) {
    //         foreach ($user->courses as $course) {
    //             $user->courseAttempts()->create([
    //                 'course_id' => $course->id,
    //                 'attempts_left' => $basicPlan->number_of_attempts ?? 1,
    //             ]);
    //         }
    //         $user->markCourseAttemptsAsInitialized();
    //     }

    //     Notification::make()
    //         ->title('Your courses have been registered successfully.')
    //         ->success()
    //         ->send();

    //     return redirect()->route('filament.user.pages.dashboard');
    // }

    public function registerCourses()
    {
        Log::info('Starting registerCourses method');

        if (count($this->selectedCourses) < 1) {
            Log::warning('No courses selected');
            Notification::make()
                ->title('Please select at least one course')
                ->info()
                ->send();
            return redirect()->route('courses.page', ['examid' => $this->examId]);
        }

        Log::info('Selected courses count: ' . count($this->selectedCourses));

        $basicPlan = Plan::where('title', 'Free Plan')->first();
        Log::info('Basic Plan found: ' . ($basicPlan ? 'Yes' : 'No'));

        
        Log::info('User ID: ' . $this->user->id);

        try {
            $this->user->assignRole('noun_student');
            Log::info('Role assigned: noun_student');
        } catch (\Exception $e) {
            Log::error('Error assigning role: ' . $e->getMessage());
        }

        if ($basicPlan) {
            try {
                $subscription = $this->user->subscriptions()->create([
                    'plan_id' => $basicPlan->id,
                    'starts_at' => now(),
                    'ends_at' => now()->addYears(10),
                    'status' => 'active',
                    'features' => $basicPlan->features
                ]);
                Log::info('Subscription created: ' . $subscription->id);
            } catch (\Exception $e) {
                Log::error('Error creating subscription: ' . $e->getMessage());
                return redirect()->back()->withErrors('Error creating subscription.');
            }
        } else {
            Log::error('Free Plan not found during user registration.', ['user_id' => $this->user->id]);
            return redirect()->back()->withErrors('Free Plan not found.');
        }

        try {
            $this->user->courses()->detach();
            $this->user->courses()->attach($this->selectedCourses);
            
            Log::info('Courses attached: ' . implode(', ', $this->selectedCourses));
        } catch (\Exception $e) {
            Log::error('Error attaching courses: ' . $e->getMessage());
        }

        $this->user->exam_id = $this->examId;
        // $this->user->registration_status = \App\Models\User::STATUS_REGISTRATION_COMPLETED;
        $this->user->update(['registration_status' => User::STATUS_REGISTRATION_COMPLETED]);

        try {
            $this->user->save();
            Log::info('User updated with exam_id and registration_status');
        } catch (\Exception $e) {
            Log::error('Error saving user: ' . $e->getMessage());
        }

        if (!$this->user->hasInitializedCourseAttempts()) {
            try {
                foreach ($this->user->courses as $course) {
                    $attempt = $this->user->courseAttempts()->create([
                        'course_id' => $course->id,
                        'attempts_left' => $basicPlan->number_of_attempts ?? 1,
                    ]);
                    Log::info('Course attempt created: ' . $attempt->id . ' for course: ' . $course->id);
                }
                $this->user->markCourseAttemptsAsInitialized();
                Log::info('Course attempts initialized');
            } catch (\Exception $e) {
                Log::error('Error initializing course attempts: ' . $e->getMessage());
            }
        }
        $this->user->updateRegistrationStatus();
        Notification::make()
            ->title('Your courses have been registered successfully.')
            ->success()
            ->send();

        Log::info('Registration completed, redirecting to dashboard');

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
