<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

/**
 * Allows easy interaction with the session
 *
 * @author Jordan
 */
class Session
{
    /**
     * Check if the session has a value
     *
     * @param string $property The property to get
     *
     * @return bool
     */
    public function has(string $property): bool
    {
        return array_key_exists($property, $_SESSION);
    }

    /**
     * Get a session value
     *
     * @param string $property Which property to get
     *
     * @return mixed
     */
    public function get(string $property)
    {
        if (!$this->has($property)) {
            return null;
        }

        return $_SESSION[$property];
    }

    /**
     * Put a session value
     *
     * @param string $property The property to put
     * @param mixed  $value    The value to put
     *
     * @return void
     */
    public function put(string $property, $value): void
    {
        $_SESSION[$property] = $value;
    }

    /**
     * Get and then forget a session property
     *
     * @param string $property The property to pull
     *
     * @return mixed
     */
    public function pull(string $property)
    {
        $value = $this->get($property);
        if (is_null($value)) {
            return $value;
        }

        $this->forget($property);
        return $value;
    }

    /**
     * Forget a session value
     *
     * @param string $property The property to forget
     *
     * @return void
     */
    public function forget(string $property): void
    {
        unset($_SESSION[$property]);
    }
}
