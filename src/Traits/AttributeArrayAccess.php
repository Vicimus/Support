<?php

declare(strict_types=1);

namespace Vicimus\Support\Traits;

/**
 * Can be used to implement the ArrayAccess interface on anything
 * that uses an attribute array style property storage (ImmutableObject)
 *
 * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
 * @property mixed[] $attributes
 */
trait AttributeArrayAccess
{
    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->attributes);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->attributes[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->$offset = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->attributes[$offset]);
    }
}
