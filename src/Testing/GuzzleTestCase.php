<?php declare(strict_types = 1);

namespace Vicimus\Support\Testing;

/**
 * Class GuzzleTestCase
 */
abstract class GuzzleTestCase extends TestCase
{
    use GuzzleRequests;
}
