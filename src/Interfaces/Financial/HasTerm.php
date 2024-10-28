<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Financial;

interface HasTerm
{
    public function term(): float;
}
