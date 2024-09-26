<?php

declare(strict_types=1);

namespace Vicimus\Support\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Support\Facades\Auth;
use Vicimus\Support\Interfaces\OnyxUser;

class Authentication
{
    public function __construct(
        protected readonly Factory $manager,
    ) {
        //
    }

    /**
     * Forward the request on to the facade
     */
    public function check(): bool
    {
        return Auth::check();
    }

    /**
     * Get the current user
     *
     * @return Authenticatable|OnyxUser
     */
    public function user(): ?Authenticatable
    {
        return Auth::user();
    }
}
