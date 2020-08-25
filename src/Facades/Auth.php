<?php

declare(strict_types=1);

namespace Vicimus\Support\Facades;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth as LaravelAuth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Auth
 *
 * @method static Authenticatable user()
 * @method static bool check()
 * @method static Response basic()
 * @method static bool guest()
 */
class Auth extends LaravelAuth
{
    //
}
