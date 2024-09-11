<?php

namespace App\Models;

use App\Models\Bank;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\ReferralPayment;
use App\Models\SchoolRegistrationLink;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_name',
        'account_name',
        'account_number',
        'bank_id',
        'percentage',
        'fixed_rate',
        'referral_code',
        'subaccount_code',
        'is_school',
        'parent_agent_id'
    ];

    /**
     * The "booted" method of the model.
     * Generates a unique referral code when a new agent is created.
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($agent) {
            $agent->referral_code = Str::random(10);
            $agent->save();
        });
    }

    /**
     * Get the user associated with the agent.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the referral payments for the agent.
     *
     * @return HasMany
     */
    public function referralPayments(): HasMany
    {
        return $this->hasMany(ReferralPayment::class);
    }

    /**
     * Get the school agents associated with this agent.
     *
     * @return HasMany
     */
    public function schoolAgents(): HasMany
    {
        return $this->hasMany(Agent::class, 'parent_agent_id')->where('is_school', true);
    }

    /**
     * Get the parent agent (for schools).
     *
     * @return BelongsTo
     */
    public function parentAgent(): BelongsTo
    {
        return $this->belongsTo(Agent::class, 'parent_agent_id');
    }


    /**
     * Get the schools referred by this agent.
     *
     * @return HasMany
     */
    public function referredSchools(): HasMany
    {
        return $this->hasMany(Agent::class, 'parent_agent_id')->where('is_school', true);
    }

    /**
     * Get the users referred by this agent.
     *
     * @return BelongsToMany
     */
    public function referredUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'agent_user')
            ->withPivot('referred_at')
            ->withTimestamps();
    }

    /**
     * Get the school registration links for the agent.
     *
     * @return HasMany
     */
    public function schoolRegistrationLinks(): HasMany
    {
        return $this->hasMany(SchoolRegistrationLink::class);
    }

    /**
     * Get the bank associated with the agent.
     *
     * @return BelongsTo
     */
    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }
}