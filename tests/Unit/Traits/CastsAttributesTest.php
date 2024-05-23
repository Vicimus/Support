<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Traits;

use Vicimus\Support\Classes\ImmutableObject;
use Vicimus\Support\Testing\TestCase;
use Vicimus\Support\Traits\CastsAttributes;

/**
 * Class CastsAttributesTest
 */
class CastsAttributesTest extends TestCase
{
    /**
     * Do casts
     */
    public function testDoCasts(): void
    {
        $instance = new class {
            use CastsAttributes;

            /**
             * @var string[]
             */
            protected array $casts = [
                'banana' => 'int',
                'strawberry' => ImmutableObject::class,
            ];

            /**
             * Cast a value
             * @param mixed $value The value to cast
             *
             */
            public function get(mixed $value): mixed
            {
                return $this->doAttributeCast('banana', $value);
            }

            /**
             * Cast nothing
             *
             * @param mixed $value The value
             *
             */
            public function noCast(mixed $value): mixed
            {
                return $this->doAttributeCast('not-found', $value);
            }

            /**
             * Cast many things
             *
             * @param mixed $value The value to cast
             *
             */
            public function strawberry(mixed $value): mixed
            {
                return $this->doAttributeCast('strawberry', $value);
            }
        };

        $this->assertSame(1, $instance->get('1'));
        $this->assertNull($instance->get(null));
        $this->assertSame('1', $instance->noCast('1'));

        $results = $instance->strawberry([
            [
                'id' => 1,
            ],
            [
                'id' => 2,
            ],
        ]);
        $this->assertIsArray($results);

        $this->assertInstanceOf(ImmutableObject::class, $results[0]);
    }
}
