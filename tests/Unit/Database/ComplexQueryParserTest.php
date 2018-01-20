<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Database;

use Illuminate\Database\Query\Builder;
use PHPUnit\Framework\MockObject\MockObject;
use Vicimus\Support\Database\ComplexQueryParser;
use Vicimus\Support\Exceptions\InvalidArgumentException;
use Vicimus\Support\Testing\TestCase;

/**
 * Class ComplexQueryParserTest
 */
class ComplexQueryParserTest extends TestCase
{
    /**
     * Test isComplexQuery
     *
     * @return void
     */
    public function testIsComplexQuery(): void
    {
        $parser = new ComplexQueryParser();
        $this->assertFalse($parser->isComplexQuery('hello'));

        $this->assertFalse($parser->isComplexQuery(['id' => 1]));

        $this->assertTrue($parser->isComplexQuery('in:(1,2,3)'));
    }

    /**
     * Test complex
     *
     * @return void
     */
    public function testComplex(): void
    {
        $parser = new ComplexQueryParser();
        try {
            $parser->query('hello', 'banana', 'in:1,2,3');
            $this->wasExpectingException(InvalidArgumentException::class);
        } catch (InvalidArgumentException $ex) {
            $this->assertContains('Builder', $ex->getMessage());
        }

        /** @var Builder|MockObject $query */
        $query = $this->getMockBuilder(Builder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $query->expects($this->once())
            ->method('whereIn')
            ->will($this->returnSelf());

        $result = $parser->query($query, 'banana', 'in:1,2,3');
        $this->assertInstanceOf(Builder::class, $result);

        /** @var Builder|MockObject $query */
        $query = $this->getMockBuilder(Builder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $query->expects($this->once())
            ->method('where')
            ->will($this->returnSelf());

        $result = $parser->query($query, 'banana', 'in:1,2,3,null');
        $this->assertInstanceOf(Builder::class, $result);
        $result->get();

        /** @var Builder|MockObject $query */
        $query = $this->getMockBuilder(Builder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $query->expects($this->once())
            ->method('where')
            ->will($this->returnSelf());

        $result = $parser->query($query, 'banana', 'gt:now');
        $this->assertInstanceOf(Builder::class, $result);

        /** @var Builder|MockObject $query */
        $query = $this->getMockBuilder(Builder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $query->expects($this->once())
            ->method('where')
            ->will($this->returnSelf());

        $result = $parser->query($query, 'banana', 'like:strawberry');
        $this->assertInstanceOf(Builder::class, $result);

        /** @var Builder|MockObject $query */
        $query = $this->getMockBuilder(Builder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $query->expects($this->once())
            ->method('where')
            ->will($this->returnSelf());

        $result = $parser->query($query, 'banana', 'lt:now');
        $this->assertInstanceOf(Builder::class, $result);
    }
}
