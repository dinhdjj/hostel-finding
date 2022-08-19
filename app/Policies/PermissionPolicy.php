<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PermissionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response|bool
    {
        return $user->hasPermissionTo('permissions.view.any');
    }

    public function view(User $user, Permission $permission): Response|bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): Response|bool
    {
        return false;
    }

    public function update(User $user, Permission $permission): Response|bool
    {
        return false;
    }

    public function deleteAny(User $user): Response|bool
    {
        return false;
    }

    public function delete(User $user, Permission $permission): Response|bool
    {
        return false;
    }
}
