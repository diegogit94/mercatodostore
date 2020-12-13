<?php

namespace App\Policies;

use App\Product;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return Response
     */
    public function create(User $user): Response
    {
        return $user->user_type === 'admin'
            ? Response::allow()
            : Response::deny('Not admin, You shall not pass!');
    }

    /**
     * @param User $user
     * @return Response
     */
    public function update(User $user)
    {
        return $user->user_type === 'admin'
            ? Response::allow()
            : Response::deny('Not admin, You shall not pass!');
    }

    /**
     * @param User $user
     * @return Response
     */
    public function delete(User $user)
    {
        return $user->user_type === 'admin'
            ? Response::allow()
            : Response::deny('Not admin, You shall not pass!');
    }
}
