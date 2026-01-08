<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Classes;

use Vicimus\Support\Classes\Exports\ExportArtifact;
use Vicimus\Support\Testing\TestCase;

class ExportArtifactTest extends TestCase
{
    public function testConstructor(): void
    {
        $artifact = new ExportArtifact('disk', 'path', 'filename', 1);
        $this->assertEquals('disk', $artifact->disk);
        $this->assertEquals('path', $artifact->path);
        $this->assertEquals('filename', $artifact->filename);
        $this->assertEquals(1, $artifact->size);
    }
}
