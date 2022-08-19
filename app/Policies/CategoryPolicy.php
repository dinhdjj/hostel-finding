<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response|bool
    {
        return $user->hasPermissionTo('categories.view.any');
    }

    public function view(User $user, Category $category): Response|bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): Response|bool
    {
        return $user->hasPermissionTo('categories.create.any');
    }

    public function update(User $user, Category $category): Response|bool
    {
        return $user->hasPermissionTo('categories.update.any');
    }

    public function deleteAny(User $user): Response|bool
    {
        return $user->hasPermissionTo('categories.delete.any');
    }

    public function delete(User $user, Category $category): Response|bool
    {
        return $this->deleteAny($user);
    }
}
