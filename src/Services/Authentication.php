<?php

declare(strict_types=1);

namespace Vicimus\Support\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Support\Facades\Auth;
use Vicimus\Onyx\User;

/**
 * Class Authentication
 */
class Authentication
{
    /**
     * The auth manager
     *
     */
    protected Factory $manager;

    /**
     * Authentication constructor.
     *
     * @param Factory $manager The auth manager
     */
    public function __construct(Factory $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Forward the request on to the facade
     *
     */
    public function check(): bool
    {
        return Auth::check();
    }

    /**
     * Get the current user
     *
     * @return Authenticatable|User
     */
    public function user(): ?Authenticatable
    {
        return Auth::user();
    }
}
