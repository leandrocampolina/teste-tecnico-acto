<?php

namespace App\Policies;

use App\Models\Form;
use App\Models\User;

class FormPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Form $form): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        return $form->is_active;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Form $form): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Form $form): bool
    {
        return $user->isAdmin();
    }

    public function respond(User $user, Form $form): bool
    {
        return $form->is_active;
    }
}
