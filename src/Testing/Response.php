<?php declare(strict_types = 1);

namespace Vicimus\Support\Testing;

use Illuminate\Http\Response as LaravelResponse;

/**
 * Class Response
 */
class Response extends LaravelResponse
{
    /**
     * Asset response status
     *
     * @param int $code The response code
     *
     * @return void
     */
    public function assertResponseStatus(int $code): void
    {
        //
    }
}
