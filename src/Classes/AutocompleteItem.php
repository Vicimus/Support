<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

/**
 * Class AutocompleteItem
 */
class AutocompleteItem extends ImmutableObject
{
    /**
     * AutocompleteItem constructor
     *
     * @param string|int      $id          The id of the item
     * @param string          $name        The name to display
     * @param int|string|null $details     Optionally details
     * @param string|null     $detailsIcon An icon to display
     */
    public function __construct($id, string $name, $details, ?string $detailsIcon)
    {
        parent::__construct([
            'id' => $id,
            'name' => $name,
            'details' => $details,
            'detailsIcon' => $detailsIcon,
        ]);
    }
}
