<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\API;

use Vicimus\Support\Classes\ImmutableObject;

/**
 * @property string $url
 * @property string $id
 * @property string $secret
 */
class Credentials extends ImmutableObject
{
    public function __construct(?string $url, ?string $id, ?string $secret)
    {
        parent::__construct([
            'url' => $url,
            'id' => $id,
            'secret' => $secret,
        ]);
    }
}
