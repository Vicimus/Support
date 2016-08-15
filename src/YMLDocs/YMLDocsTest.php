<?php

namespace Vicimus\Support\YMLDocs;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;

/**
 * A phpunit test class to easily test your YMLDoc Documentation.
 *
 * This test will ensure:
 *      - your listed endpoints behave as expected
 *      - your schemas returned match the specification
 *
 * @author Jordan Grieve <jgrieve@vicimus.com>
 */
class YMLDocsTest extends TestCase
{
    /**
     * Holds the Guzzle client
     *
     * @var \GuzzleHttp\Client
     */
    private $http;

    /**
     * Hold the defined schemas
     *
     * @var mixed[]
     */
    protected $schemas = [];

    /**
     * Set up the guzzle client
     */
    public function __construct($path)
    {
        parent::__construct();
        $this->http = new Client([

        ]);

        $contents = file_get_contents($path);
        $global = Yaml::parse($contents);
        if (array_key_exists('schemaDefinitions', $global)) {
            $this->schemas = $global['schemaDefinitions'];
        }
    }
}
