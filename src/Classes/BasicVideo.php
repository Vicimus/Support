<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

use Vicimus\Support\Interfaces\Video;

/**
 * Basic Video
 */
class BasicVideo implements Video
{
    /**
     * The type of video ie/ youtube, flickfusion, etc.
     *
     * @var string
     */
    protected $type = '';

    /**
     * The value for the video
     *
     * @var string
     */
    protected $value = '';

    /**
     * Create a BasicVideo Instance
     *
     * @param string $type  The type of video
     * @param string $value The video code or url
     */
    public function __construct(string $type, string $value)
    {
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * Get the type of video ie/ youtube, flickfusion, etc.
     *
     * @return string
     */
    public function videoType(): string
    {
        return $this->type;
    }

    /**
     * Get the value for the video
     *
     * @return string
     */
    public function videoValue(): string
    {
        return $this->value;
    }
}
