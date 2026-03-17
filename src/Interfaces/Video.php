<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

interface Video
{
    public function videoType(): string;

    public function videoValue(): string;
}
