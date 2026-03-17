<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Exceptions;

use PHPUnit\Framework\TestCase;
use Vicimus\Support\Exceptions\RestException;

/**
 * Class RestExceptionTest
 */
class RestExceptionTest extends TestCase
{
    /**
     * Test json serialized
     *
     */
    public function testJson(): void
    {
        $rest = new RestException('Bad News', 500);
        $this->assertEquals('Bad News', $rest->getMessage());

        $encode = json_decode(json_encode($rest));
        $this->assertEquals('Bad News', $encode->error);
    }
}
