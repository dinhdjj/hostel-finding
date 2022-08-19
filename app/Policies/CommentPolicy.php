<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Comment;
use App\Models\Hostel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CommentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response|bool
    {
        return $user->hasPermissionTo('comments.view.any');
    }

    public function view(User $user, Comment $comment): Response|bool
    {
        return true;
    }

    public function create(User $user, Hostel $hostel): Response|bool
    {
        return true;
    }

    public function update(User $user, Comment $comment): Response|bool
    {
        return $user->hasPermissionTo('comments.update.any') || $user->id === $comment->owner_id;
    }

    public function deleteAny(User $user): Response|bool
    {
        return $user->hasPermissionTo('comments.delete.any');
    }

    public function delete(User $user, Comment $comment): Response|bool
    {
        return $this->deleteAny($user) || $user->id === $comment->owner_id;
    }
}
