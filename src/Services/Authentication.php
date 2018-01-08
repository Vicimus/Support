<?php declare(strict_types = 1);

namespace Vicimus\Support\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Support\Facades\Auth;

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
     * @return Authenticatable
     */
    public function user(): ?Authenticatable
    {
        return Auth::user();
    }
}
