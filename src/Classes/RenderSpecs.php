<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

use Illuminate\Http\Request;

/**
 * @property int $width
 * @property int $height
 * @property int $scale
 * @property int $pages
 * @property bool $letter
 * @property bool $postcard
 * @property string $format
 */
class RenderSpecs extends ImmutableObject
{
    public function __construct(
        Request | int | null $width,
        ?int $height = null,
        ?int $scale = null,
        ?int $pages = null,
        bool $letter = true,
        bool $postcard = false,
        ?string $format = null
    ) {
        if ($width instanceof Request) {
            $pages = (int) $width->get('pages');
            $height = (int) $width->get('height');
            $scale = (int) $width->get('scale');
            $letter = $width->get('letter');
            $postcard = $width->get('postcard');
            $format = $width->get('pageType');
            $width = (int) $width->get('width');
        }

        parent::__construct([
            'width' => $width,
            'height' => $height,
            'scale' => $scale,
            'pages' => $pages,
            'letter' => $letter,
            'postcard' => $postcard,
            'format' => $format,
        ]);
    }
}
