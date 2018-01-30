<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces;

interface HasPrice
{
    public function msrp(): float;
    public function price(): float;
}
