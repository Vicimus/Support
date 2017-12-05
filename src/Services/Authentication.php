<?php declare(strict_types = 1);

namespace Vicimus\Support\Services;

use Illuminate\Support\Facades\Auth;
use Vicimus\Onyx\User;

/**
 * Class Authentication
 */
class Authentication
{
    /**
     * Get the current user
     *
     * @return User|\Illuminate\Contracts\Auth\Authenticatable
     */
    public function user(): ?User
    {
        return Auth::user();
    }
}
