<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

/**
 * Allows easy interaction with the session
 */
class Session
{
    /**
     * Forget a session value
     */
    public function forget(string $property): void
    {
        unset($_SESSION[$property]);
    }

    /**
     * Get a session value
     */
    public function get(string $property): mixed
    {
        if (!$this->has($property)) {
            return null;
        }

        return $_SESSION[$property];
    }

    /**
     * Check if the session has a value
     */
    public function has(string $property): bool
    {
        return array_key_exists($property, $_SESSION);
    }

    /**
     * Get and then forget a session property
     */
    public function pull(string $property): mixed
    {
        $value = $this->get($property);
        if ($value === null) {
            return $value;
        }

        $this->forget($property);
        return $value;
    }

    public function put(string $property, mixed $value): void
    {
        $_SESSION[$property] = $value;
    }
}
