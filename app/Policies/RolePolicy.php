<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response|bool
    {
        return $user->hasPermissionTo('roles.view.any');
    }

    public function view(User $user, Role $role): Response|bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): Response|bool
    {
        return $user->hasPermissionTo('roles.create.any');
    }

    public function update(User $user, Role $role): Response|bool
    {
        return $user->hasPermissionTo('roles.update.any');
    }

    public function deleteAny(User $user): Response|bool
    {
        return $user->hasPermissionTo('roles.delete.any');
    }

    public function delete(User $user, Role $role): Response|bool
    {
        return $this->deleteAny($user);
    }
}
