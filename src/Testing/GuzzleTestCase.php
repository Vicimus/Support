<?php

declare(strict_types=1);

namespace Vicimus\Support\Testing;

abstract class GuzzleTestCase extends TestCase
{
    use GuzzleRequests;
}
