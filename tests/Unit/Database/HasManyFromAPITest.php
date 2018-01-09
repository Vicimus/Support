<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Database;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use stdClass;
use Throwable;
use Vicimus\Support\Database\ApiModel;
use Vicimus\Support\Database\Relations\HasManyFromAPI;

/**
 * Class HasManyFromAPITest
 */
class HasManyFromAPITest extends TestCase
{
    /**
     * Test the associate method
     *
     * @return void
     */
    public function testAssociate(): void
    {
        /** @var DatabaseManager|MockObject $db */
        $db = $this->getMockBuilder(DatabaseManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['connection'])
            ->getMock();

        $builder = $this->getMockBuilder(Builder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $builder->expects($this->exactly(3))
            ->method('insert');

        $connection = $this->getMockBuilder(ConnectionInterface::class)
            ->getMock();

        $connection->method('table')
            ->willReturn($builder);

        $db->method('connection')
            ->willReturn($connection);

        $has = new HasManyFromAPI($db, 1, 'bananas', 'strawberries');
        $has->casts([
            'whatever' => 'int',
        ]);

        $has->associate([1, 2, 3]);
    }

    /**
     * Test failing the method
     *
     * @return void
     */
    public function testAssociateFail(): void
    {
        /** @var DatabaseManager|MockObject $db */
        $db = $this->getMockBuilder(DatabaseManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['connection'])
            ->getMock();

        $builder = $this->getMockBuilder(Builder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $builder->method('select')
            ->will($this->returnSelf());

        $connection = $this->getMockBuilder(ConnectionInterface::class)
            ->getMock();

        $connection->method('table')
            ->willReturn($builder);

        $db->method('connection')
            ->willReturn($connection);

        $has = new HasManyFromAPI($db, 1, 'bananas', 'strawberries');
        try {
            $has->associate(['1']);
        } catch (InvalidArgumentException $ex) {
            $this->assertContains('int', $ex->getMessage());
        } catch (Throwable $ex) {
            $this->fail($ex->__toString());
        }
    }

    /**
     * Test counting the number of relatives
     *
     * @return void
     */
    public function testCount(): void
    {
        /** @var DatabaseManager|MockObject $db */
        $db = $this->getMockBuilder(DatabaseManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['connection'])
            ->getMock();

        $builder = $this->getMockBuilder(Builder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $builder->method('select')
            ->will($this->returnSelf());
        $builder->method('where')
            ->will($this->returnSelf());

        $builder->method('get')
            ->willReturn(new Collection([1, 2, 3]));

        $connection = $this->getMockBuilder(ConnectionInterface::class)
            ->getMock();

        $connection->method('table')
            ->willReturn($builder);

        $db->method('connection')
            ->willReturn($connection);

        $has = new HasManyFromAPI($db, 1, 'bananas', 'strawberries');

        $count = $has->count();
        $this->assertEquals(3, $count);
    }

    /**
     * Test disassociate
     *
     * @return void
     */
    public function testDisassociate(): void
    {
        /** @var DatabaseManager|MockObject $db */
        $db = $this->getMockBuilder(DatabaseManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['connection'])
            ->getMock();

        $builder = $this->getMockBuilder(Builder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $builder->expects($this->once())
            ->method('whereIn')
            ->will($this->returnSelf());

        $builder->expects($this->once())
            ->method('delete')
            ->will($this->returnSelf());

        $connection = $this->getMockBuilder(ConnectionInterface::class)
            ->getMock();

        $connection->method('table')
            ->willReturn($builder);

        $db->method('connection')
            ->willReturn($connection);

        $has = new HasManyFromAPI($db, 1, 'bananas', 'strawberries');

        $has->dissociate([]);
        $has->dissociate(['1, 2, 3']);
    }

    /**
     * Test the find method
     *
     * @return void
     */
    public function testFind(): void
    {
        /** @var DatabaseManager|MockObject $db */
        $db = $this->getMockBuilder(DatabaseManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['connection'])
            ->getMock();

        $builder = $this->getMockBuilder(Builder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $builder->expects($this->exactly(2))
            ->method('where')
            ->will($this->returnSelf());

        $builder->expects($this->once())
            ->method('select')
            ->will($this->returnSelf());

        $connection = $this->getMockBuilder(ConnectionInterface::class)
            ->getMock();

        $connection->method('table')
            ->willReturn($builder);

        $db->method('connection')
            ->willReturn($connection);

        $has = new HasManyFromAPI($db, 1, 'bananas', 'strawberries');
        $match = $has->find(1);
        $this->assertInstanceOf(ApiModel::class, $match);
    }

    /**
     * Test the find method
     *
     * @return void
     */
    public function testGet(): void
    {
        /** @var DatabaseManager|MockObject $db */
        $db = $this->getMockBuilder(DatabaseManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['connection'])
            ->getMock();

        $builder = $this->getMockBuilder(Builder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $builder->expects($this->exactly(1))
            ->method('where')
            ->will($this->returnSelf());

        $builder->expects($this->once())
            ->method('select')
            ->will($this->returnSelf());

        $builder->method('get')
            ->willReturn(new Collection([['id' => 1], ['id' => 2], ['id' => 3]]));

        /** @var ConnectionInterface|\PHPUnit\Framework\MockObject\MockObject $connection */
        $connection = $this->getMockBuilder(ConnectionInterface::class)
            ->getMock();

        $connection->method('table')
            ->willReturn($builder);

        $db->method('connection')
            ->willReturn($connection);

        $match = new Collection();
        $has = new HasManyFromAPI($db, 1, 'bananas', 'strawberries');
        try {
            $match = $has->get();
        } catch (Throwable $ex) {
            $this->fail($ex->__toString());
        }

        $this->assertInstanceOf(stdClass::class, $match->first());
    }
}
