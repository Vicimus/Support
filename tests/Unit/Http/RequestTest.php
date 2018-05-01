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
}
