<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Http;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request as IllRequest;
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
     * Test complex query
     *
     * @return void
     */
    public function testIsComplex(): void
    {
        $request = new Request([
            'status' => 'in:1,2,3',
        ]);

        $this->assertTrue($request->isComplexQuery());
    }

    /**
     * Test the bind method
     *
     * @return void
     */
    public function testBind(): void
    {
        $request = new Request([]);

        $this->assertFalse($request->isComplexQuery());

        $this->assertNotNull($request->bind('banana', static function () {
            return 'strawberry';
        }));
    }

    /**
     * Test get
     *
     * @return void
     */
    public function testGet(): void
    {
        $request = new Request([
            'banana' => 'strawberry',
            'status' => '3',
        ]);

        $this->assertEquals('strawberry', $request->get('banana'));
        $this->assertEquals(3, $request->get('status', 0, 'int'));
        $this->assertEquals('apples', $request->get('plums', 'apples'));
    }

    /**
     * Test the built in order by stuff
     *
     * @return void
     */
    public function testOrderBy(): void
    {
        $request = new Request([
            'orderBy' => 'status',
        ]);

        $this->assertEquals(['status', 'asc'], $request->orderBy());

        $request = new Request([]);
        $this->assertEquals(['id', 'asc'], $request->orderBy());

        $request = new Request([
            'orderBy' => 'vehicle:owner.status',
        ]);

        $this->assertEquals(['vehicle', 'owner.status'], $request->orderBy());
    }

    /**
     * Test except excludes
     *
     * @return void
     */
    public function testExcept(): void
    {
        $request = new Request([
            'banana' => 'strawberry',
            'status' => '3',
        ]);

        $this->assertEquals(['status' => 3], $request->except('banana'));

        $request = new Request([
            'banana' => 'strawberry',
            'status' => '3',
            'juju' => 'smithschuster',
        ]);

        $this->assertEquals(['juju' => 'smithschuster'], $request->except(['banana', 'status']));
    }

    /**
     * Test has
     *
     * @return void
     */
    public function testHas(): void
    {
        $request = new Request([
            'banana' => 'strawberry',
        ]);

        $this->assertTrue($request->has('banana'));
        $this->assertFalse($request->has('strawberry'));
    }

    /**
     * Test receiving the illuminate request
     *
     * @return void
     */
    public function testToRequest(): void
    {
        $request = new Request([
            'banana' => 'strawberry',
        ]);
        $this->assertInstanceOf(IllRequest::class, $request->toRequest());
    }
}
