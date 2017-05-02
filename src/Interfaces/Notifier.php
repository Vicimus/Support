<?php

namespace Vicimus\Support\Interfaces;

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
    const TONE_BASIC = 'basic';

    /**
     * Indicates a success tone
     *
     * @var string
     */
    const TONE_SUCCESS = 'success';

    /**
     * Indicates a error tone
     *
     * @var string
     */
    const TONE_ERROR = 'error';

    /**
     * Indicates a warning tone
     *
     * @var string
     */
    const TONE_WARNING = 'warning';

    /**
     * Indicates a info tone
     *
     * @var string
     */
    const TONE_INFO = 'info';

    /**
     * Indicates a question tone
     *
     * @var string
     */
    const TONE_QUESTION = 'question';

    /**
     * Return all notifications
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function get(
        ?int $userid,
        ?int $storeid,
        ?string $product,
        ?string $package,
        ?string $tone,
        bool $expired = false
    );

    /**
     * Generate a new notification
     *
     * @param string $title   The title of the notification
     * @param string $message The message body of the notification
     * @param array  $options Any other advanced options for the notification
     *
     * @return Collection
     */
    public function notify(string $title, $message, array $options);

    /**
     * Mark a notification as read
     *
     * @return bool
     */
    public function read(int $id);

    /**
     * Generate a new notification
     *
     * @param string $title   The title of the notification
     * @param string $message The message body of the notification
     * @param array  $options Any other advanced options for the notification
     *
     * @return Collection
     */
    public function basic(string $title, $message, array $options);

    /**
     * Generate a new notification
     *
     * @param string $title   The title of the notification
     * @param string $message The message body of the notification
     * @param array  $options Any other advanced options for the notification
     *
     * @return Collection
     */
    public function success(string $title, $message, array $options);

    /**
     * Generate a new notification
     *
     * @param string $title   The title of the notification
     * @param string $message The message body of the notification
     * @param array  $options Any other advanced options for the notification
     *
     * @return Collection
     */
    public function warning(string $title, $message, array $options);

    /**
     * Generate a new notification
     *
     * @param string $title   The title of the notification
     * @param string $message The message body of the notification
     * @param array  $options Any other advanced options for the notification
     *
     * @return Collection
     */
    public function error(string $title, $message, array $options);

    /**
     * Generate a new notification
     *
     * @param string $title   The title of the notification
     * @param string $message The message body of the notification
     * @param array  $options Any other advanced options for the notification
     *
     * @return Collection
     */
    public function info(string $title, $message, array $options);

    /**
     * Generate a new notification
     *
     * @param string $title   The title of the notification
     * @param string $message The message body of the notification
     * @param array  $options Any other advanced options for the notification
     *
     * @return Collection
     */
    public function question(string $title, $message, array $options);
}
