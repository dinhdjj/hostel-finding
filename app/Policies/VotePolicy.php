<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Hostel;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class VotePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response|bool
    {
        return $user->hasPermissionTo('votes.view.any');
    }

    public function view(User $user, Vote $vote): Response|bool
    {
        return true;
    }

    public function create(User $user, Hostel $hostel): Response|bool
    {
        return ! $hostel->votes()->where('owner_id', $user->id)->exists();
    }

    public function update(User $user, Vote $vote): Response|bool
    {
        return $user->hasPermissionTo('votes.update.any') || $user->id === $vote->owner_id;
    }

    public function deleteAny(User $user): Response|bool
    {
        return $user->hasPermissionTo('votes.delete.any');
    }

    public function delete(User $user, Vote $vote): Response|bool
    {
        return $this->deleteAny($user) || $user->id === $vote->owner_id;
    }
}
