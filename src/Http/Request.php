<?php

namespace Vicimus\Support\Http;

use Illuminate\Http\Request as LaravelRequest;

/**
 * Class Request
 */
class Request extends LaravelRequest
{
    /**
     * Get
     *
     * @param string $key     The key to get
     * @param mixed  $default The default
     * @param bool   $deep    Deep
     *
     * @return mixed|string|null
     */
    public function get($key, $default = null, $deep = false)
    {
        $result = parent::get($key, $default, $deep);
        if ($result === null) {
            $result = $this->input($key, $default);
        }

        if ($result === null) {
            return $default;
        }

        return $result;
    }
}
