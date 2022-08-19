<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use App\Models\Visit;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class VisitPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response|bool
    {
        return $user->hasPermissionTo('visits.view.any');
    }

    public function view(User $user, Visit $visit): Response|bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): Response|bool
    {
        return false;
    }

    public function update(User $user, Visit $visit): Response|bool
    {
        return false;
    }

    public function deleteAny(User $user): Response|bool
    {
        return false;
    }

    public function delete(User $user, Visit $visit): Response|bool
    {
        return false;
    }
}
