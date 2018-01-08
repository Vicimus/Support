<?php declare(strict_types = 1);

namespace Vicimus\Support\Services;

use Illuminate\Auth\AuthManager;
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
     * @var AuthManager
     */
    protected $manager;

    /**
     * Authentication constructor.
     *
     * @param AuthManager $manager The auth manager
     */
    public function __construct(AuthManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Forward the request on to the facade
     *
     * @return bool
     */
    public function check(): bool
    {
        return Auth::check();
    }

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
