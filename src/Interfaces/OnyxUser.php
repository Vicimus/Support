<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * @property int|string $id
 * @property bool $admin
 * @property Carbon $updated_at
 * @property Store $store
 */
interface OnyxUser extends Authenticatable
{
    /**
     * Get a custom value
     */
    public function custom(string $property, mixed $default = null): mixed;

    /**
     * Get the active store
     */
    public function getActiveStore(): ?Store;

    /**
     * Check if the user belongs to a specific group by ID
     */
    public function hasGroupById(int $id, bool $ignoreAdmin = false): bool;

    /**
     * Check if the user belongs to a specific store by ID
     */
    public function hasStoreById(int $id, bool $ignoreAdmin = false): bool;

    /**
     * Is the user an admin.
     *
     * Just use `->admin` instead but this has been used so has to exist for now.
     */
    public function isAdmin(): bool;

    /**
     * Determine if a user needs to reset their password
     */
    public function shouldResetPassword(): bool;
}
