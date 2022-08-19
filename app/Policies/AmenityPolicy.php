<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Amenity;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AmenityPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response|bool
    {
        return $user->hasPermissionTo('amenities.view.any');
    }

    public function view(User $user, Amenity $amenity): Response|bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): Response|bool
    {
        return $user->hasPermissionTo('amenities.create.any');
    }

    public function update(User $user, Amenity $amenity): Response|bool
    {
        return $user->hasPermissionTo('amenities.update.any');
    }

    public function deleteAny(User $user): Response|bool
    {
        return $user->hasPermissionTo('amenities.delete.any');
    }

    public function delete(User $user, Amenity $amenity): Response|bool
    {
        return $this->deleteAny($user);
    }
}
