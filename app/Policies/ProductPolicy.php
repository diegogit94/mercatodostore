<?php

namespace App\Policies;

use App\Product;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Product $product)
    public function update(User $user)
    {
        return $user->user_type === 'admin';
    }
    public function delete(User $user)
    {
        return $user->user_type === 'admin';
    }
}
