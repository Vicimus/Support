<?php

declare(strict_types=1);

namespace Vicimus\Support\Testing;

use Illuminate\Http\Response as LaravelResponse;

class Response extends LaravelResponse
{
    public function assertResponseStatus(int $code): void
    {
        //
    }
}
