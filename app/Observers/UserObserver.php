<?php

namespace App\Observers;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */

    public function created(User $user): void
    {
        // Retrieve the Basic Access Plan, if it doesn't exist, log an error or handle it accordingly.
        $basicPlan = Plan::where('title', 'Explorer Access Plan')->first();

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

            // Initialize the user's quiz attempts.
            $user->jambAttempts()->create([
                'attempts_left' => $basicPlan->number_of_attempts ?? 1 // Number of attempts from the plan
            ]);
            // based on the subscription or specific features enabled by the plan.
            // This might not be needed if quiz attempts are managed through the subscription features.
        } else {
            // Log error or handle the situation where the Explorer Access Plan doesn't exist.
            Log::error('Explorer Access Plan not found during user registration.', ['user_id' => $user->id]);
        }
    }


    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}