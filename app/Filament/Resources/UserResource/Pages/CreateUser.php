<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Models\Plan;
use Filament\Actions;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $record = new ($this->getModel())();
// dd($record);
        $record->first_name = $data['first_name'];
        $record->last_name = $data['last_name'];
        $record->phone = $data['phone'];
        $record->email = $data['email'];
        $record->password = $data['password']; // Remember to hash the password
        $record->exam_id = $data['exam_id'];
        $record->is_on_trial = $data['is_on_trial'];
        $record->trial_ends_at = $data['trial_ends_at'];

        $record->save();

        // Attach subjects or courses to the user
        if (isset($data['subjects'])) {
            $record->subjects()->attach($data['subjects']);

            $basicPlan = Plan::where('title', 'Explorer Access Plan')->first();

            if ($basicPlan) {
                // Create a subscription for the basic plan. Since it's a free plan, you might not set an expiration date,
                // or set a very distant future date if you want to enforce checking subscription validity.
                $record->subscriptions()->create([
                    'plan_id' => $basicPlan->id,
                    'starts_at' => now(),
                    'ends_at' => now()->addYears(10), // Optional: for a free plan, you might not need an expiration.
                    'status' => 'active', // Consider your logic for setting status
                    'features' => $basicPlan->features // Copying features from plan to subscription
                ]);
            } else {
                // Log error or handle the situation where the Explorer Access Plan doesn't exist.
                Log::error('Explorer Access Plan not found during user registration.', ['user_id' => $record->id]);
            }

            if (!$basicPlan) {
                // Handle the case where the basic plan is not found
                // Possibly log an error or set a flash message

                return redirect()->back()->withErrors('Explorer Access Plan not found.');
            }

            // Initialize the user's quiz attempts.
            $record->jambAttempts()->create([
                'attempts_left' => $basicPlan->number_of_attempts ?? 1 // Number of attempts from the plan
            ]);

         
            $record->registration_status = \App\Models\User::STATUS_REGISTRATION_COMPLETED;

            if (!$record->hasInitializedSubjectAttempts()) {
                foreach ($record->subjects as $subject) {
                    $record->subjectAttempts()->create([
                        'subject_id' => $subject->id,
                        'attempts_left' => $basicPlan->number_of_attempts ?? 1,
                    ]);
                }
                $record->markSubjectAttemptsAsInitialized();
            }
        }

        if (isset($data['courses'])) {
            $record->courses()->attach($data['courses']);

            // Retrieve the Basic Access Plan, if it doesn't exist, log an error or handle it accordingly.
            $basicPlan = Plan::where('title', 'Free Access Plan')->first();

            if ($basicPlan) {
                // Create a subscription for the basic plan. Since it's a free plan, you might not set an expiration date,
                // or set a very distant future date if you want to enforce checking subscription validity.
                $record->subscriptions()->create([
                    'plan_id' => $basicPlan->id,
                    'starts_at' => now(),
                    'ends_at' => now()->addYears(10), // Optional: for a free plan, you might not need an expiration.
                    'status' => 'active', // Consider your logic for setting status
                    'features' => $basicPlan->features // Copying features from plan to subscription
                ]);
            } else {
                // Log error or handle the situation where the Free Access Plan doesn't exist.
                Log::error('Free Access Plan not found during user registration.', ['user_id' => $record->id]);
            }

            if (!$basicPlan) {
                return redirect()->back()->withErrors('Free Access Plan not found.');
            }


            if (!$record->hasInitializedCourseAttempts()) {
                foreach ($record->courses as $course) {
                    $record->courseAttempts()->create([
                        'course_id' => $course->id,
                        'attempts_left' => $basicPlan->number_of_attempts ?? 1,
                    ]);
                }
                $record->markCourseAttemptsAsInitialized();
            }
            $record->registration_status = \App\Models\User::STATUS_REGISTRATION_COMPLETED;
        }
       

        return $record;
    }
}
