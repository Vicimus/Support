<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces;

use Illuminate\Support\Collection;

/**
 * Contract for a notifier
 */
interface Notifier
{
    /**
     * Indicates a basic tone
     *
     * @var string
     */
    public const TONE_BASIC = 'basic';

    /**
     * Indicates a success tone
     *
     * @var string
     */
    public const TONE_SUCCESS = 'success';

    /**
     * Indicates a error tone
     *
     * @var string
     */
    public const TONE_ERROR = 'error';

    /**
     * Indicates a warning tone
     *
     * @var string
     */
    public const TONE_WARNING = 'warning';

    /**
     * Indicates a info tone
     *
     * @var string
     */
    public const TONE_INFO = 'info';

    /**
     * Indicates a question tone
     *
     * @var string
     */
    public const TONE_QUESTION = 'question';

    /**
     * Return all notifications
     *
     * @param int    $userid  The ID of the User
     * @param int    $storeid The ID of the store
     * @param string $product The specific product
     * @param string $package The specific package
     * @param string $tone    The specific tone
     * @param bool   $expired Include expired notifications
     *
     * @return Collection
     */
    public function get(
        int $userid,
        ?int $storeid,
        ?string $product,
        ?string $package,
        ?string $tone,
        bool $expired = false
    ): Collection;

    /**
     * Generate a new notification
     *
     * @param string   $title   The title of the notification
     * @param string   $message The message body of the notification
     * @param string[] $options Any other advanced options for the notification
     *
     * @return Collection
     */
    public function notify(string $title, string $message, array $options): Collection;

    /**
     * Mark a notification as read
     *
     * @param int $id The ID to mark as read
     *
     * @return bool
     */
    public function read(int $id): bool;

    /**
     * Generate a new notification
     *
     * @param string   $title   The title of the notification
     * @param string   $message The message body of the notification
     * @param string[] $options Any other advanced options for the notification
     *
     * @return Collection
     */
    public function basic(string $title, string $message, array $options): Collection;

    /**
     * Generate a new notification
     *
     * @param string   $title   The title of the notification
     * @param string   $message The message body of the notification
     * @param string[] $options Any other advanced options for the notification
     *
     * @return Collection
     */
    public function success(string $title, string $message, array $options): Collection;

    /**
     * Generate a new notification
     *
     * @param string   $title   The title of the notification
     * @param string   $message The message body of the notification
     * @param string[] $options Any other advanced options for the notification
     *
     * @return Collection
     */
    public function warning(string $title, string $message, array $options): Collection;

    /**
     * Generate a new notification
     *
     * @param string   $title   The title of the notification
     * @param string   $message The message body of the notification
     * @param string[] $options Any other advanced options for the notification
     *
     * @return Collection
     */
    public function error(string $title, string $message, array $options): Collection;

    /**
     * Generate a new notification
     *
     * @param string   $title   The title of the notification
     * @param string   $message The message body of the notification
     * @param string[] $options Any other advanced options for the notification
     *
     * @return Collection
     */
    public function info(string $title, string $message, array $options): Collection;

    /**
     * Generate a new notification
     *
     * @param string   $title   The title of the notification
     * @param string   $message The message body of the notification
     * @param string[] $options Any other advanced options for the notification
     *
     * @return Collection
     */
    public function question(string $title, string $message, array $options): Collection;
}
