<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Log;

trait HasRegistrationStatus
{
    public function isRegistrationComplete(): bool
    {
        if ($this->registration_status !== User::STATUS_REGISTRATION_COMPLETED) {
            return false;
        }

        // Check for JAMB registration (4 or more subjects)
        if ($this->subjects()->count() >= 4) {
            return true;
        }

        // Check for NOUN registration (at least one course)
        if ($this->courses()->count() > 0) {
            return true;
        }

        return false;
    }

    // public function updateRegistrationStatus(): void
    // {
    //     if ($this->subjects()->count() >= 4 || $this->courses()->count() > 0) {
    //         $this->update(['registration_status' => User::STATUS_REGISTRATION_COMPLETED]);
    //     } else {
    //         $this->update(['registration_status' => User::STATUS_REGISTRATION_INCOMPLETE]);
    //     }
    // }

    public function updateRegistrationStatus(): void
    {
        Log::info('Starting updateRegistrationStatus method for user ID: ' . $this->id);

        $subjectCount = $this->subjects()->count();
        $courseCount = $this->courses()->count();

        Log::info("Current counts - Subjects: $subjectCount, Courses: $courseCount");

        if ($subjectCount >= 4 || $courseCount > 0) {
            Log::info('Conditions met for completed registration');
            try {
                $this->update(['registration_status' => User::STATUS_REGISTRATION_COMPLETED]);
                Log::info('Registration status updated to COMPLETED');
            } catch (\Exception $e) {
                Log::error('Failed to update registration status to COMPLETED: ' . $e->getMessage());
            }
        } else {
            Log::info('Conditions not met for completed registration');
            try {
                $this->update(['registration_status' => User::STATUS_REGISTRATION_INCOMPLETE]);
                Log::info('Registration status updated to INCOMPLETE');
            } catch (\Exception $e) {
                Log::error('Failed to update registration status to INCOMPLETE: ' . $e->getMessage());
            }
        }

        // Verify the update
        $this->refresh();
        Log::info('After update - Registration status: ' . $this->registration_status);
    }
}
