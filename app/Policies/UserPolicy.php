<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response|bool
    {
        return $user->hasPermissionTo('users.view.any');
    }

    public function view(User $user, User $model): Response|bool
    {
        return $user->is($model) || $this->viewAny($user);
    }

    public function create(User $user): Response|bool
    {
        return $user->hasPermissionTo('users.create');
    }

    public function update(User $user, User $model): Response|bool
    {
        return $user->hasPermissionTo('users.update.any');
    }

    public function deleteAny(User $user): Response|bool
    {
        return $user->hasPermissionTo('users.delete.any');
    }

    public function delete(User $user, User $model): Response|bool
    {
        return $this->deleteAny($user);
    }
}
