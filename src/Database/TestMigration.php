<?php

declare(strict_types=1);

namespace Vicimus\Support\Database;

interface TestMigration
{
    public function testUp(): void;
}
