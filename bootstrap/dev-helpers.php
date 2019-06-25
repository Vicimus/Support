<?php declare(strict_types = 1);

use Vicimus\Support\Testing\Application;

if (!function_exists('app')) {
    /**
     * Get an instance of something or other
     *
     * @noinspection PhpDocMissingThrowsInspection
     *
     * @param string $abstract The thing to get
     *
     * @return Application|mixed
     */
    function app(?string $abstract = null)
    {
        $app = Application::getInstance();
        if (!$abstract) {
            return $app;
        }

        return $app->make($abstract);
    }
}
