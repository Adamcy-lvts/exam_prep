<?php

namespace App\Traits;

use App\Models\User;

trait HasRegistrationStatus
{
    public function isRegistrationComplete(): bool
    {
        return $this->registration_status === User::STATUS_REGISTRATION_COMPLETED
            && $this->subjects()->count() >= 4;
    }

    public function updateRegistrationStatus(): void
    {
        if ($this->subjects()->count() >= 4) {
            $this->update(['registration_status' => User::STATUS_REGISTRATION_COMPLETED]);
        } else {
            $this->update(['registration_status' => User::STATUS_REGISTRATION_INCOMPLETE]);
        }
    }
}
