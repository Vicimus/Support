<?php

namespace Vicimus\Support\Testing;

use Illuminate\Http\Response as LaravelResponse;

class Response extends LaravelResponse
{
    public function assertResponseStatus($code)
    {
        //
    }
}
