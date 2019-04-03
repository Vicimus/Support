<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Vicimus\Support\Classes\ConquestDataSourceInfo as Info;

/**
 * Class ConquestDataCategoryInfo
 */
class ConquestDataCategoryInfo extends ImmutableObject
{
    /**
     * ConquestDataCategoryInfo constructor.
     *
     * @param string            $name        The name
     * @param View|string       $description The description
     * @param string            $image       A full url to an image
     * @param Collection|Info[] $sources     Data sources that fall within the category
     */
    public function __construct(string $name, $description, string $image, Collection $sources)
    {
        if ($description instanceof View) {
            $description = $description->render();
        }

        parent::__construct([
            'name' => $name,
            'description' => $description,
            'image' => $image,
            'sources' => $sources,
        ]);
    }
}
