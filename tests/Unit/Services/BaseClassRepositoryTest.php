<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\ImmutableObject;
use Vicimus\Support\Services\BaseClassRepository;

class BaseClassRepositoryTest extends TestCase
{
    public function testGet(): void
    {
        $repo = new BaseClassRepository();
        $this->assertCount(0, $repo->get());

        $repo->register(ImmutableObject::class);
        $this->assertCount(1, $repo->get());
        $this->assertTrue($repo->isRegistered(ImmutableObject::class));
    }
}
