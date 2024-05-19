<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Filament\Panel;
use App\Models\Exam;
use App\Models\Plan;
use App\Models\Agent;
use App\Models\Topic;
use App\Models\Course;
use App\Models\Payment;
use App\Models\Subject;
use App\Models\JambAttempt;
use App\Models\QuizAttempt;
use App\Models\Subscription;
use App\Models\CourseAttempt;
use App\Models\SubjectAttempt;
use App\Models\UserQuizAttempt;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\HasName;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser, HasName, MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use HasPanelShield;

    // Define constants for registration status
    const STATUS_REGISTRATION_COMPLETED = 'registration_completed';

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {

            return ($this->email === 'lv4mj1@gmail.com');
        }

        if ($panel->getId() === 'user') {

            return $this->hasRole('panel_user');
        }

        if ($panel->getId() === 'agent') {

            return $this->user_type = 'agent';
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
        'course_attempts_initialized_at',
        'exam_id',
        'user_type',
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
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }
    
    public function agent()
    {
        return $this->hasOne(Agent::class);
    }

    public function referringAgents()
    {
        return $this->belongsToMany(Agent::class, 'agent_user')
            ->withPivot('referred_at')
            ->withTimestamps();
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function QuizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class, 'topic_users')->withPivot('unlocked')->withTimestamps();
    }


    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }


    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function latestSubscriptionStatus()
    {

        return $this->subscriptions()->latest()->first();
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
        $currentSubscription = $this->latestSubscriptionStatus();

        if ($currentSubscription && Carbon::parse($currentSubscription->ends_at)->isPast()) {
            // Subscription has ended
            $currentSubscription->update(['status' => 'expired']);

            // Detach the subscription from the user
            // $this->subscriptions()->detach($currentSubscription->id);


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

    public function hasCourseAttemptsForAnyCourse()
    {
        // Assuming each subject attempt is tracked individually
        return $this->courseAttempts()->where('attempts_left', '>', 0)->exists();
    }

    public function getFilamentName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
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

    public function isRegisteredForSubject()
    {
        return $this->subjects()->exists();
    }

    public function isRegisteredForCourse()
    {
        return $this->courses()->exists();
    }

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

    public function hasInitializedCourseAttempts()
    {
        return $this->course_attempts_initialized_at != null;
    }
    public function markCourseAttemptsAsInitialized()
    {
        $this->course_attempts_initialized_at = now();
        $this->save();
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
