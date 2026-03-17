<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

interface ConsoleOutput
{
    public function comment(string $output): void;

    public function error(string $output): void;

    public function info(string $output): void;

    public function line(string $output): void;

    public function linePermanent(string $output): void;
}
