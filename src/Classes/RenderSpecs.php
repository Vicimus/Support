<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

use Illuminate\Http\Request;

/**
 * Class RenderSpecs
 *
 * @property int $width
 * @property int $height
 * @property int $scale
 * @property int $pages
 * @property bool $letter
 */
class RenderSpecs extends ImmutableObject
{
    /**
     * RenderSpecs constructor.
     *
     * @param Request|int|null $width    The width of the pdf element
     * @param int|null         $height   The height of the pdf element
     * @param int|null         $scale    The scale to use
     * @param int|null         $pages    The number of pages
     * @param bool             $letter   The letter
     * @param bool             $postcard The postcard toggle
     */
    public function __construct(
        $width,
        ?int $height = null,
        ?int $scale = null,
        ?int $pages = null,
        bool $letter = true,
        bool $postcard = false
    ) {
        if ($width instanceof Request) {
            $pages = (int) $width->get('pages');
            $height = (int) $width->get('height');
            $scale = (int) $width->get('scale');
            $letter = $width->get('letter');
            $postcard = $width->get('postcard');
            $width = (int) $width->get('width');
        }

        parent::__construct([
            'width' => $width,
            'height' => $height,
            'scale' => $scale,
            'pages' => $pages,
            'letter' => $letter,
            'postcard' => $postcard,
        ]);
    }
}
