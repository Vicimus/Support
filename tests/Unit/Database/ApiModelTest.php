<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Database;

use PHPUnit\Framework\MockObject\MockObject;
use Throwable;
use Vicimus\Support\Database\ApiModel;
use Vicimus\Support\Database\Relations\HasManyFromAPI;
use Vicimus\Support\Exceptions\ApiRelationException;
use Vicimus\Support\Testing\TestCase;

/**
 * Class ApiModelTest
 */
class ApiModelTest extends TestCase
{
    /**
     * Test the magic methods
     *
     * @throws Throwable
     *
     * @return void
     */
    public function testMagics(): void
    {
        /** @var HasManyFromAPI|MockObject $db */
        $db = $this->getMockBuilder(HasManyFromAPI::class)
            ->disableOriginalConstructor()
            ->getMock();

        $db->expects($this->once())
            ->method('update')
            ->willReturn(true);

        $model = new ApiModel($db, [
            'id' => 1,
            'banana' => 'strawberry',
        ]);

        $this->assertEquals('strawberry', $model->banana);

        $model->banana = 'apple';

        $this->assertEquals('apple', $model->banana);

        $model->update([
            'banana' => 'kiwi',
        ]);
    }

    /**
     * Test exception throwing
     *
     * @return void
     */
    public function testUpdateWithoutId(): void
    {
        /** @var HasManyFromAPI|MockObject $db */
        $db = $this->getMockBuilder(HasManyFromAPI::class)
            ->disableOriginalConstructor()
            ->getMock();

        $db->expects($this->never())
            ->method('update');

        $model = new ApiModel($db, [
            'banana' => 'strawberry',
        ]);

        try {
            $model->update([]);
            $this->wasExpectingException(ApiRelationException::class);
        } catch (ApiRelationException $ex) {
            $this->assertContains('id', $ex->getMessage());
        }
    }
}
