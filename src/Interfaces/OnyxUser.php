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
     *
     * @param string     $property The property to get
     * @param string|int $default  The default fallback
     *
     */
    public function custom(string $property, string|int|null $default = null): string|int|bool|null;

    /**
     * Get the active store
     *
     */
    public function getActiveStore(): ?Store;

    /**
     * Check if the user belongs to a specific group by ID
     *
     * @param int  $id          The group ID to check
     * @param bool $ignoreAdmin Ignore admin and check if the user actually has the store
     *
     */
    public function hasGroupById(int $id, bool $ignoreAdmin = false): bool;

    /**
     * Check if the user belongs to a specific store by ID
     *
     * @param int  $id          The store ID to check
     * @param bool $ignoreAdmin Ignore admin and check if the user actually has the store
     *
     */
    public function hasStoreById(int $id, bool $ignoreAdmin = false): bool;

    /**
     * Is the user an admin.
     *
     * Just use `->admin` instead but this has been used so has to exist for now.
     *
     */
    public function isAdmin(): bool;

    /**
     * Determine if a user needs to reset their password
     *
     */
    public function shouldResetPassword(): bool;
}
