<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

/**
 * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
 * @property int $id
 * @property mixed[] $additionalDetails
 */
class AutocompleteItem extends ImmutableObject
{
    public function __construct(
        string | int $id,
        string $name,
        mixed $details,
        ?string $detailsIcon,
        mixed $additionalDetails = null,
    ) {
        parent::__construct([
            'id' => $id,
            'name' => $name,
            'details' => $details,
            'detailsIcon' => $detailsIcon,
            'additionalDetails' => $additionalDetails,
        ]);
    }
}
