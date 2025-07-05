<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Validation;

class ValidationPolicy
{
    public function view(User $user, Validation $validation): bool
    {
        return $user->isAdmin()   ||  $user->isFormateur() ||  $user->id === $validation->validated_by;
    }

    public function update(User $user, Validation $validation): bool
    {
        return $user->isAdmin() || $user->isFormateur() || $user->id === $validation->validated_by;
            
    }

    public function delete(User $user, Validation $validation): bool
    {
        return $user->isAdmin();
    }
}
