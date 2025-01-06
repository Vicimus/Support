<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

/**
 * phpcs:disable
 *
 * @property int $id
 * @property mixed $value
 */
interface PropertyRecord
{
    public function getId(): string | int | null;

    public function getValue(): mixed;

    public function name(): string;

    public function validate(mixed $value): void;
}
