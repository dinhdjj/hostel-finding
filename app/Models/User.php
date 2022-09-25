<?php

declare(strict_types=1);

namespace App\Models;

use Cache;
use Dinhdjj\Visit\Traits\Visitor;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasRoles;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Visitor;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'id_number',
        'phone_number',
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
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function hostels(): HasMany
    {
        return $this->hasMany(Hostel::class, 'owner_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'owner_id');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class, 'owner_id');
    }

    public function hostelVotes(): HasManyThrough
    {
        return $this->hasManyThrough(Vote::class, Hostel::class, 'owner_id');
    }

    public function subscribedHostels(): BelongsToMany
    {
        return $this->belongsToMany(Hostel::class)->withTimestamps();
    }

    public function canAccessFilament(): bool
    {
        return $this->hasPermissionTo('view.admin-page');
    }

    public function describe(): array
    {
        return Cache::remember('user-'.$this->getKey().'-describe', 60 * 60 * 24, function () {
            $hostelVotesCount = $this->hostelVotes()->count() ?? 0;

            return [
                'hostels_count' => $this->hostels()->count() ?? 0,
                'hostel_votes_count' => $hostelVotesCount,
                'hostel_votes_score_avg' => $this->hostelVotes()->avg('score') ?? 0,
            ];
        });
    }
}
