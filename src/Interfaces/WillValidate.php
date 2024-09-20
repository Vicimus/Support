<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

interface WillValidate
{
    public function getValidationMessage(): ?string;

    public function isValid(): bool;
}
