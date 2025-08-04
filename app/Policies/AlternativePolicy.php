<?php

namespace App\Policies;

use App\Models\Alternative;
use App\Models\User;

class AlternativePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Alternative $alternative): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Alternative $alternative): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Alternative $alternative): bool
    {
        return $user->isAdmin();
    }
}
