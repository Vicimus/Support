<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

/**
 * Class ComplexValue
 *
 * Represents a select option on the front end which may provide additional data
 *
 * @property string|int|null $value
 * @property string $label
 * @property string|null $additional
 */
class ComplexValue extends ImmutableObject
{
    /**
     * ComplexValue constructor
     *
     * @param string|int|null $value      The value of the option
     * @param string          $label      The display text of the option
     * @param string|null     $additional Additional data to use in the display
     */
    public function __construct($value, string $label, ?string $additional = null)
    {
        parent::__construct([
            'value' => $value,
            'label' => $label,
            'additional' => $additional,
        ]);
    }
}
