<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Database;

use Illuminate\Database\DatabaseManager;
use PHPUnit\Framework\TestCase;
use Throwable;
use Vicimus\Support\Database\APIAssociates;
use Vicimus\Support\Database\Relations\HasManyFromAPI;
use Vicimus\Support\Exceptions\ApiRelationException;

/**
 * Class APIAssociatesTest
 */
class APIAssociatesTest extends TestCase
{
    /**
     * Ensure the relation works
     *
     * @return void
     */
    public function testHasMany(): void
    {
        /* @var APIAssociates|MockObject $mock */
        $mock = $this->getMockForTrait(APIAssociates::class);

        /* @var DatabaseManager|MockObject $db */
        $db = $this->getMockBuilder(DatabaseManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $result = null;
        $mock->id = 1;
        $mock->table = 'bananas';

        try {
            $result = $mock->hasManyFromApi($db, 'Whatever');
        } catch (Throwable $ex) {
            $this->fail($ex->__toString());
        }

        $this->assertInstanceOf(HasManyFromAPI::class, $result);
    }

    /**
     * Ensure the relation works
     *
     * @return void
     */
    public function testHasManyFails(): void
    {
        /* @var APIAssociates|MockObject $mock */
        $mock = $this->getMockForTrait(APIAssociates::class);

        /* @var DatabaseManager|MockObject $db */
        $db = $this->getMockBuilder(DatabaseManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $result = null;
        $mock->id = 1;

        try {
            $mock->hasManyFromApi($db, 'Whatever');
            $this->fail('Was expecting ' . ApiRelationException::class);
        } catch (ApiRelationException $ex) {
            $this->assertContains('table', $ex->getMessage());
        }

        unset($mock->id);

        try {
            $mock->hasManyFromApi($db, 'Whatever');
            $this->fail('Was expecting ' . ApiRelationException::class);
        } catch (ApiRelationException $ex) {
            $this->assertContains('id', $ex->getMessage());
        }
    }
}
