<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

use Illuminate\Support\Collection;

interface Notifier
{
    /**
     * Indicates a basic tone
     */
    public const TONE_BASIC = 'basic';

    /**
     * Indicates a error tone
     */
    public const TONE_ERROR = 'error';

    /**
     * Indicates a info tone
     */
    public const TONE_INFO = 'info';

    /**
     * Indicates a question tone
     */
    public const TONE_QUESTION = 'question';

    /**
     * Indicates a success tone
     */
    public const TONE_SUCCESS = 'success';

    /**
     * Indicates a warning tone
     *
     */
    public const TONE_WARNING = 'warning';

    /**
     * Generate a new notification
     *
     * @param string   $title   The title of the notification
     * @param string   $message The message body of the notification
     * @param string[] $options Any other advanced options for the notification
     */
    public function basic(string $title, string $message, array $options): Collection;

    /**
     * Generate a new notification
     *
     * @param string   $title   The title of the notification
     * @param string   $message The message body of the notification
     * @param string[] $options Any other advanced options for the notification
     */
    public function error(string $title, string $message, array $options): Collection;

    /**
     * Return all notifications
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
     */
    public function info(string $title, string $message, array $options): Collection;

    /**
     * Generate a new notification
     *
     * @param string   $title   The title of the notification
     * @param string   $message The message body of the notification
     * @param string[] $options Any other advanced options for the notification
     */
    public function notify(string $title, string $message, array $options): Collection;

    /**
     * Generate a new notification
     *
     * @param string   $title   The title of the notification
     * @param string   $message The message body of the notification
     * @param string[] $options Any other advanced options for the notification
     */
    public function question(string $title, string $message, array $options): Collection;

    /**
     * Mark a notification as read
     */
    public function read(int $id): bool;

    /**
     * Generate a new notification
     *
     * @param string   $title   The title of the notification
     * @param string   $message The message body of the notification
     * @param string[] $options Any other advanced options for the notification
     */
    public function success(string $title, string $message, array $options): Collection;

    /**
     * Generate a new notification
     *
     * @param string   $title   The title of the notification
     * @param string   $message The message body of the notification
     * @param string[] $options Any other advanced options for the notification
     */
    public function warning(string $title, string $message, array $options): Collection;
}
