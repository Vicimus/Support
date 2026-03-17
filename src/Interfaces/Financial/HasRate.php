<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Financial;

interface HasRate
{
    public function rate(): float;
}
