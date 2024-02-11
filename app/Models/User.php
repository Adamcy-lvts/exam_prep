<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use App\Models\Plan;
use App\Models\Course;
use App\Models\Subject;
use App\Models\JambAttempt;
use App\Models\Subscription;
use App\Models\CourseAttempt;
use App\Models\SubjectAttempt;
use App\Models\UserQuizAttempt;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\HasName;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser, HasName, MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    // Define constants for registration status
    const STATUS_REGISTRATION_COMPLETED = 'registration_completed';

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return ($this->email === 'lv4mj1@gmail.com');
        }

        return true;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
    
        'first_name',
        'last_name',
        'phone',
        'email',
        'password',
        'subject_attempts_initialized_at',
        'is_on_trial',
        'trial_ends_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */

    // public function hasActiveUnlimitedPlan()
    // {
    //     return $this->plans()
    //         ->where('number_of_attempts', null) // Unlimited plans have null attempts
    //         ->wherePivot('expires_at', '>', now()) // Plan is still within the validity period
    //         ->exists();
    // }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    // Method to get the current active subscription
    public function currentSubscription()
    {
        return $this->subscriptions()
            ->where('status', 'active')
            ->where('ends_at', '>', now())
            ->latest('starts_at')
            ->first();
    }

    public function switchToFreePlanIfSubscriptionEnded()
    {
        // Assuming you have a method 'currentSubscription()' that fetches the current active subscription
        $currentSubscription = $this->currentSubscription();

        if ($currentSubscription && $currentSubscription->end_date->isPast()) {
            // Subscription has ended
            $freePlan = Plan::where('title', 'Explorer Access Plan')->first(); // Retrieve your default free plan

            if ($freePlan) {
                // Create a new subscription record for the free plan
                $this->subscriptions()->create(['plan_id' => $freePlan->id,
                    'starts_at' => now(),
                    'ends_at' => now()->addYears(10),
                    'status' => 'active', // Consider your logic for setting status
                    'features' => $freePlan->features // Copying features from plan to subscription
                ]);

                // Update the current subscription status to inactive if needed
                $currentSubscription->update(['status' => 'inactive']);
            }
        }
    }

    // In your User model or a dedicated service class
    public function hasActiveSubscription($planId)
    {
        return $this->subscriptions()->active()->where('plan_id', $planId)->exists();
    }


    public function hasFeature($feature)
    {
        // Check active subscriptions for the feature
        return $this->subscriptions()
            ->where('status', 'active')
            ->where('ends_at', '>', now()) // Active subscriptions
            ->whereJsonContains('features', $feature) // Check if features JSON column contains the specific feature
            ->exists();
    }


    public function jambAttempts()
    {
        return $this->hasOne(JambAttempt::class);
    }

    public function subjectAttempts()
    {
        return $this->hasMany(SubjectAttempt::class);
    }

    public function courseAttempts()
    {
        return $this->hasMany(CourseAttempt::class);
    }

    public function hasSubjectAttemptsForAnySubject()
    {
        // Assuming each subject attempt is tracked individually
        return $this->subjectAttempts()->where('attempts_left', '>', 0)->exists();
    }

    public function getFilamentName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }


    // User.php
    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    // User.php

    // public function plans()
    // {
    //     return $this->belongsToMany(Plan::class, 'user_plans');
    // }

    // public function currentPlan()
    // {
    //     return $this->plans()
    //         ->latest('created_at') // assuming 'pivot_created_at' is a field in the pivot table
    //         ->first();
    // }



    public function hasJambAttempts()
    {
        $jambAttempt = $this->jambAttempts()->first();
        return $jambAttempt && $jambAttempt->attempts_left > 0;
    }


    public function hasSubjectAttempt($subjectId)
    {
        return $this->subjectAttempts()->where('subject_id', $subjectId)
            ->where('attempts_left', '>', 0)
            ->exists();
    }


    public function hasCourseAttempts($courseId)
    {
        return $this->courseAttempts()->where('course_id', $courseId)
            ->where('attempts_left', '>', 0)
            ->exists();
    }


    public function useJambAttempts(User $user)
    {
        $jambAttempt = $user->jambAttempts()->first();
        if ($jambAttempt && $jambAttempt->attempts_left > 0) {
            $jambAttempt->decrement('attempts_left');
            return true;
        }
        return false;
    }

  


    public function useSubjectAttempt($subjectId)
    {
        $attempt = $this->subjectAttempts()->where('subject_id', $subjectId)->first();
        if ($attempt && $attempt->attempts_left > 0) {
            $attempt->decrement('attempts_left');
            return true;
        }
        return false;
    }


    public function useCourseAttempt($courseId)
    {
        $attempt = $this->courseAttempts()->where('course_id', $courseId)->first();
        if ($attempt && $attempt->attempts_left > 0) {
            $attempt->decrement('attempts_left');
            return true;
        }
        return false;
    }

    public function onTrial()
    {
        return $this->is_on_trial && $this->trial_ends_at->isFuture();
    }

    public function useTrialAttempt()
    {
        if ($this->onTrial()) {
            // Logic to decrement a trial attempt.
            // This could involve decrementing a 'trial_attempts' column
            // or simply ending the trial if only one attempt is allowed.
        }
    }

    public function hasInitializedSubjectAttempts()
    {
        return $this->subject_attempts_initialized_at != null;
    }

    public function markSubjectAttemptsAsInitialized()
    {
        $this->subject_attempts_initialized_at = now();
        $this->save();
    }

}
