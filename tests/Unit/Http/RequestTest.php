<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Http;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request as IllRequest;
use PHPUnit\Framework\MockObject\MockObject;
use Vicimus\Support\Http\Request;
use Vicimus\Support\Testing\TestCase;

/**
 * Class RequestTest
 */
class RequestTest extends TestCase
{
    /**
     * Test select
     *
     * @return void
     */
    public function testSelect(): void
    {
        $ill = new IllRequest([
            'fields' => 'id,model_code',
        ]);

        $request = new Request($ill);

        $select = $request->select();
        $this->assertEquals(['id', 'model_code'], $select);

        $request = new Request(new IllRequest());
        $this->assertEquals(['*'], $request->select());
    }

    /**
     * Test with
     *
     * @return void
     */
    public function testFields(): void
    {
        $ill = new IllRequest([
            'with' => 'bananas,strawberries',
        ]);

        $request = new Request($ill);

        $with = $request->with();
        $this->assertEquals(['bananas', 'strawberries'], $with);
    }

    /**
     * Test params
     *
     * @return void
     */
    public function testParams(): void
    {
        $ill = new IllRequest([
            'with' => 'bananas,strawberries',
            'fields' => 'id,model_code',
            'store_id' => 118,
        ]);

        $request = new Request($ill);

        $params = $request->all();
        $this->assertEquals(['store_id' => 118], $params);
    }

    /**
     * Test query builder
     *
     * @return void
     */
    public function testQueryBuilder(): void
    {
        $ill = new IllRequest([
            'with' => 'bananas,strawberries',
            'fields' => 'id,model_code',
            'store_id' => 118,
        ]);

        $request = new Request($ill);

        /** @var Builder|MockObject $builder */
        $builder = $this->getMockBuilder(Builder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $builder->expects($this->once())
            ->method('select')
            ->willReturnSelf();

        $builder->expects($this->once())
            ->method('with')
            ->willReturnSelf();

        $builder->expects($this->once())
            ->method('get')
            ->willReturn(new Collection());

        $result = $request->query($builder)->get();
        $this->assertInstanceOf(Collection::class, $result);
    }
}
