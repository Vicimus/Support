<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes\API;

use Vicimus\Support\Classes\ImmutableObject;

/**
 * Class MultipartPayload
 *
 * @package Vicimus\Support\Classes\API
 */
class MultipartPayload extends ImmutableObject
{
    /**
     * MultipartPayload constructor.
     *
     * @param string          $name     The name of this payload line
     * @param string|resource $content  The content (string or file resource)
     * @param null|string     $filename The filename (Optional)
     * @param null|string     $mime     The mime type
     */
    public function __construct(
        string $name,
        $content,
        ?string $filename = null,
        ?string $mime = null
    ) {
        parent::__construct([
            'name' => $name,
            'content' => $content,
            'filename' => $filename,
            'mime' => $mime,
        ]);
    }
}
