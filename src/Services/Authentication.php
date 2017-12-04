<?php declare(strict_types = 1);

namespace Vicimus\Support\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthManager;
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
     * Get the currently authenticated user
     *
     * @return User
     */
    public function user(): ?User
    {
        return Auth::user();
    }
}
