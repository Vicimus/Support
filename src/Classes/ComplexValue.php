<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

/**
 * Represents a select option on the front end which may provide additional data
 *
 * @property string|int|null $value
 * @property string $label
 * @property string|null $additional
 */
class ComplexValue extends ImmutableObject
{
    public function __construct(string | int | null $value, string $label, ?string $additional = null)
    {
        parent::__construct([
            'value' => $value,
            'label' => $label,
            'additional' => $additional,
        ]);
    }
}
