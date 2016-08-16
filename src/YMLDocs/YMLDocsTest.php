<?php

namespace Vicimus\Support\YMLDocs;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Vicimus\YMLCollection\YMLCollection;
use Vicimus\YMLCollection\Classes\Endpoint;

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
     * Holds the last response
     *
     * @var Response
     */
    protected $lastResponse;

    /**
     * Hold the defined schemas
     *
     * @var mixed[]
     */
    protected $schemas = [];

    /**
     * The global configuration
     *
     * @var mixed[]
     */
    protected $yml;

    /**
     * Mapping of the parameter keys used for the request
     *
     * @var string[]
     */
    protected static $paramKeys = [
        'GET'       => 'query',
        'POST'      => 'form_params',
        'PATCH'     => 'form_params',
        'DELETE'    => 'query',
    ];

    /**
     * Set up the guzzle client
     */
    public function __construct($path)
    {
        parent::__construct();

        $this->yml = new YMLCollection($path);

        $this->http = new Client([
            'base_uri' => $this->yml->getGlobal()->url,
        ]);
    }

    /**
     * Set up the test
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->lastResponse = null;
    }
    
    /**
     * Execute the Doc Test
     *
     * @return void
     */
    public function testAPI()
    {
        foreach ($this->yml->names() as $name) {
            echo "\n".'Testing '.$name;

            $endpoints = $this->yml->get($name);
            foreach ($endpoints as $endpoint) {
                $this->endpointTest($endpoint);
            }
        }

        $this->assertTrue(true);
    }

    /**
     * Test an individual endpoint
     *
     * @param Endpoint $endpoint The endpoint to be tested
     *
     * @return void
     */
    protected function endpointTest(Endpoint $endpoint)
    {
        foreach ($endpoint->paths as $path => $data) {
            $operations = $data['operations'];
            foreach ($operations as $verb => $info) {
                if (array_key_exists('security', $info)) {
                    continue;
                }

                if ($verb !== 'GET') {
                    continue;
                }

                $verb = strtoupper($verb);
                echo "\n\t".'Testing '.$verb.' '.$endpoint->path.$path;
                $apiPath = $endpoint->path.$path;

                if (array_key_exists('security', $info)) {
                    $security = $info['security'];
                    if (is_array($info['security'])) {
                        $security = implode(', ', $info['security']);
                    }

                    echo " with ".$security;
                }

                $response = $this->send($verb, $apiPath);

                $this->assertResponseOK();
            }
        }
    }

    /**
     * Ensure the response was a 200
     *
     * @return void
     */
    protected function assertResponseOk()
    {
        $this->assertEquals(200, $this->lastResponse->getStatusCode());
    }

    /**
     * Send a request to the API
     *
     * @param string   $method   GET/POST/PATCH/DELETE
     * @param string   $endpoint The endpoint to use
     * @param string[] $params   The params to send
     * @param string   $token    Client token if applicable
     *
     * @return mixed[]
     */
    protected function send($method, $endpoint, array $params = array(), $token = null)
    {
        try {
            $response = $this->http->request(
                $method,
                $endpoint,
                $this->args($method, $params, $token)
            );
            $this->lastResponse = $response;
        } catch (\GuzzleHttp\Exception\ClientException $ex) {
            $this->lastResponse = $ex->getResponse();
            $response = $ex->getResponse();
        }
        
        return (string) $response->getBody();
    }

    /**
     * Generates the authorization headers
     *
     * @return mixed[]
     */
    protected function headers($token)
    {
        return [
            'headers' => [
                'authorization' => $token,
            ],
        ];
    }

    /**
     * Generate the neccessary args for use when sending a request
     *
     * @param string $method The method of the request (get/post/patch/del)
     * @param mixed  $params The parameters being sent
     *
     * @return mixed[]
     */
    protected function args($method, array $params = array(), $token = null)
    {
        if (!array_key_exists(strtoupper($method), self::$paramKeys)) {
            throw new \InvalidArgumentException(
                'Method specified does not have param key information set'
            );
        }

        $key = self::$paramKeys[strtoupper($method)];
        $args = [
            $key => $params,
        ];

        return array_merge($args, $this->headers($token));
    }

    /**
     * Run through the Schema and ensure its to spec
     *
     * @param array $schema  The schema specification
     * @param mixed $inspect The data returned by the API
     *
     * @return void
     */
    private function schemaTest($schema, array $inspect)
    {
        $schema = $this->schemas[$schema];

        /**
         * This line checks to make sure they have the exact same number
         * of properties. However it makes it difficult to know WHICH ONES
         * are extra, so it's left commented out.
         */
        //$this->assertEquals(count($schema['properties']), count($inspect));

        if (is_array($inspect)) {
            foreach ($schema['properties'] as $property => $specs) {
                $this->assertArrayHasKey($property, $inspect);
                $type = is_array($specs) ? $specs['type'] : $specs;
                $this->assertEquals(
                    $property.' is a '.$this->translateType($type),
                    $property.' is a '.$this->getReturnType(
                        $type,
                        $inspect[$property]
                    )
                );

                if ($type == 'object' && array_key_exists(
                    'properties',
                    $specs
                )) {
                    $this->subSchemaTest($specs, $inspect[$property]);
                }
            }

            foreach ($inspect as $property => $value) {
                try {
                    $this->assertNotNull($schema['properties'][$property]);
                } catch (\Exception $ex) {
                    $this->fail('Object returned by API had '.$property.' but '.
                         'that property is not part of the Schema!');
                }
            }
        }
    }

    /**
     * Run through sub schemas and ensure they match the expected schema
     *
     * @param array $subSchema The subschema to validate
     * @param array $inspect   The returned data to validate
     *
     * @return void
     */
    private function subSchemaTest($subSchema, array $inspect)
    {
        foreach ($subSchema['properties'] as $property => $specs) {
            $this->assertArrayHasKey($property, $inspect);
            $this->assertEquals(
                $property.' is a '.$this->translateType($specs['type']),
                $property.' is a '.$this->getReturnType(
                    $specs['type'],
                    $inspect[$property]
                )
            );
        }
    }

    /**
     * Required to convert object or array into object or array
     *
     * @param string $specType The spec type expected
     *
     * @return string
     */
    private function translateType($specType)
    {
        if ($specType == 'object' || $specType == 'array') {
            return 'object or array';
        }

        return $specType;
    }

    /**
     * Check a property
     *
     * @param string $expected The expected type
     * @param mixed  $property The property to inspect
     *
     * @return string
     */
    private function getReturnType($expected, $property)
    {
        if (gettype($property) === 'NULL') {
            return $expected;
        }

        if (gettype($property) === 'string' && $expected == 'DateTime') {
            $date = new \DateTime($property);
            $this->assertEquals($property, $date->format('Y-m-d H:i:s'));
            return $expected;
        }

        if ($expected == 'boolean' && gettype($property) === 'string') {
            if (in_array($property, [
                'true', 'false', '0', '1',
            ])) {
                return $expected;
            }
        }

        if ($expected == 'object' || $expected == 'array') {
            if (in_array(gettype($property), [
                'object', 'array',
            ])) {
                return 'object or array';
            }
        }

        return gettype($property);
    }

    /**
     * Check if a schema is of the type specified
     *
     * @param string $type    The type that the returned schema should be
     * @param mixed  $inspect The data returned by the API
     *
     * @return boolean
     */
    private function isOfType($type, $inspect)
    {
        if ($type == 'object') {
            return is_object($inspect);
        }

        if ($type == 'string') {
            return is_string($inspect);
        }

        return false;
    }
}
