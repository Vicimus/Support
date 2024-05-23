<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\API;

use Vicimus\Support\Classes\ImmutableObject;

/**
 * Class Credentials
 *
 * @property string $url
 * @property string $id
 * @property string $secret
 */
class Credentials extends ImmutableObject
{
    /**
     * Credentials constructor.
     *
     * @param string $url    The url
     * @param string $id     The id
     * @param string $secret The secret
     */
    public function __construct(?string $url, ?string $id, ?string $secret)
    {
        parent::__construct([
            'url' => $url,
            'id' => $id,
            'secret' => $secret,
        ]);
    }
}
