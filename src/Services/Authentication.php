<?php declare(strict_types = 1);

namespace Vicimus\Support\Services;

use Illuminate\Auth\AuthManager;
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
     * @var AuthManager
     */
    protected $manager;

    /**
     * Authentication constructor.
     *
     * @param AuthManager $manager The auth manager
     */
    public function __construct(Factory $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Get the current user
     *
     * @return Authenticatable
     */
    public function user(): ?Authenticatable
    {
        return Auth::user();
    }
}
