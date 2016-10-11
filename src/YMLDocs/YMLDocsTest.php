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
abstract class YMLDocsTest extends TestCase
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
     * Holds any defined security
     *
     * @var Closure[]
     */
    protected $security = [];

    /**
     * Holds any defined parameter generators
     *
     * @var Closure[]
     */
    protected $parameters = [];

    /**
     * Holds any defined entity generators
     *
     * @var Closure[]
     */
    protected $entities = [];

    /**
     * Hold any defined setups
     *
     * @var Closure[]
     */
    protected $setups = [];

    /**
     * Hold any defined teardowns
     *
     * @var Closure[]
     */
    protected $teardowns = [];

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
     *
     * @param string $path The path to the YML docs
     */
    public function __construct($path)
    {
        parent::__construct();

        $this->yml = new YMLCollection($path);

        $this->http = new Client([
            'base_uri' => $this->yml->getGlobal()->url,
        ]);

        $this->security = $this->security();
        $this->schemas = $this->yml->schemas();
        $this->parameters = $this->parameters();
        $this->entities = $this->entities();
        $this->setups = $this->setups();
        $this->teardowns = $this->teardowns();
    }

    /**
     * Return an array of closures, where the key is the name of the
     * security requirement, and the value is a method that injects the
     * proper values.
     *
     * @return array
     */
    protected function security()
    {
        return [];
    }

    /**
     * Return an array of closures, where the key is a combination of
     * Entity:VERB:path and the value is a closure that will populate
     * an array with parameters neccessary to test an endpoint.
     *
     * @return array
     */
    protected function parameters()
    {
        return [];
    }

    /**
     * Return an array of closures, where the key is a combination of
     * Entity:VERB:path and the value is a closure that will execute
     * various actions before a request is tested.
     *
     * @return array
     */
    protected function setups()
    {
        return [];
    }

    /**
     * Return an array of closures, where the key is a combination of
     * Entity:VERB:path and the value is a closure that will execute
     * various actions after a request is tested.
     *
     * @return array
     */
    protected function teardowns()
    {
        return [];
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
        $entity = $endpoint->name;
        if (substr($entity, -1) === 's') {
            $entity = substr($entity, 0, -1);
        }

        foreach ($endpoint->paths as $path => $data) {
            $operations = $data['operations'];
            foreach ($operations as $verb => $info) {
                if (!in_array(strtoupper($verb), [
                    'GET',
                ])) {
                    continue;
                }

                $verb = strtoupper($verb);
                $apiPath = $endpoint->path.$path;
                $key = $entity.':'.$verb.':'.$apiPath;
                echo "\n\t".'Testing '.$key;
                
                $security = null;
                if (array_key_exists('security', $info)) {
                    $security = $info['security'];
                    if (is_array($info['security'])) {
                        $security = implode(', ', $info['security']);
                    }

                    echo " with ".$security;
                }

                $parameters = [];
                if (array_key_exists('parameters', $info)) {
                    $parameters = $info['parameters'];
                }

                $params = [];
                $token = null;

                $this->applySetups($key);
                $this->applyEntity($apiPath, $verb);
                $this->applyParameters($entity, $verb, $apiPath, $parameters, $params, $token);
                $this->applySecurity($security, $params, $token);
                
                $response = $this->send($verb, $apiPath, $params, $token);

                $this->applyTeardowns($key, json_decode($response));
                $code = $this->lastResponse->getStatusCode();
                $content = (string) $this->lastResponse->getBody();
                if ($code !== 200) {
                    $this->fail($key.' failed with response: '.$content);
                }

                $code = array_key_exists(200, $info['responses']) ? 200 : 302;
                if (!array_key_exists('schema', $info['responses'][$code])) {
                    continue;
                }

                $schema = $info['responses'][$code]['schema'];

                $this->schemaTest(
                    $schema,
                    json_decode($response, true),
                    $apiPath
                );
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
     * Pass the parameters and token value and allow security closures to
     * modify the values to enable secure access.
     *
     * @param string $security The name of the security required
     * @param array  $params   The parameters to be sent with the request
     * @param string $token    The authentication header token to be used
     *
     * @return void
     */
    protected function applySecurity(
        $security = null,
        array &$params = array(),
        &$token = null
    ) {
        if (is_null($security)) {
            return false;
        }

        $parts = explode(',', $security);

        foreach ($parts as $part) {
            if (array_key_exists(trim($part), $this->security)) {
                $this->security[trim($part)]($params, $token);
                return true;
            }
        }

        $this->fail('Unable to match security: '.$security);
    }

    /**
     * Apply any custom setups for any of the endpoints
     *
     * @param string $key The setup key used to find setup
     *
     * @return void
     */
    protected function applySetups($key)
    {
        if (array_key_exists($key, $this->setups)) {
            $this->setups[$key]($this->http);
        }
    }

    /**
     * Apply any custom teardowns for any of the endpoints
     *
     * @param string $key      The setup key used to find setup
     * @param string $response The response from the server
     *
     * @return void
     */
    protected function applyTeardowns($key, $response = null)
    {
        if (array_key_exists($key, $this->teardowns)) {
            $this->teardowns[$key]($this->http, $response);
        }
    }

    /**
     * Convert special entity markers to valid values that will succeed
     *
     * @param string $path The API path
     * @param string $verb The verb
     *
     * @return void
     */
    protected function applyEntity(&$path, $verb)
    {
        if (stripos($path, '{') !== false) {
            $matches = [];
            preg_match_all("/{([a-zA-Z0-9_]*)}/", $path, $matches);
            $entities = $matches[1];

            foreach ($entities as $entity) {
                if (!array_key_exists($entity, $this->entities)) {
                    echo "\n\t\t\t".'Could not find ENTITY to replace '.$entity;

                    $this->markTestSkipped(
                        'Could not find ENTITY to replace '.$entity
                    );
                }

                $replacement = $this->entities[$entity]($this->http, $verb, $path);
                if (!$replacement) {
                    echo "\n\t\t".'No replacement found for '.$entity;
                    return false;
                }

                $path = preg_replace("/{([a-zA-Z0-9_]*)}/", $replacement, $path);
            }
        }
    }

    /**
     * Pass the parameters and token value and allow parameter closures to
     * modify the values to enable valid parameters
     *
     * @param string $entity     The name of the entity
     * @param string $verb       The HTTP verb of the operation
     * @param string $path       The path being accessed
     * @param array  $parameters The parameters or something
     * @param array  $params     The parameters to be sent with the request
     * @param string $token      The authentication header token to be used
     *
     * @return void
     */
    protected function applyParameters(
        $entity,
        $verb,
        $path,
        $parameters,
        array &$params,
        &$token = null
    ) {
        $key = $entity.':'.$verb.':'.$path;
        if (array_key_exists($key, $this->parameters)) {
            $this->parameters[$key]($params);
        }
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
        //echo "\n\t".$endpoint;

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
        // echo "\n\t";
        // echo (string) $response->getBody();

        return (string) $response->getBody();
    }

    /**
     * Generates the authorization headers
     *
     * @param string $token The token to use with the request
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
     * @param string $token  The token to use
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
     * @param array  $schema  The schema specification
     * @param mixed  $inspect The data returned by the API
     * @param string $path    The path that was requested
     *
     * @return void
     */
    private function schemaTest($schema, array $inspect, $path)
    {
        $array = false;
        if (!is_array($schema)) {
            if (stripos($schema, '[]') !== false) {
                $array = true;
                $schema = substr($schema, 0, strlen($schema) - 2);
            }
        }

        if (!is_array($schema)) {
            if (!array_key_exists($schema, $this->schemas)) {
                echo "\n\t\t\t".'Missing schema: ['.$schema.']';
                return false;
            }

            $schema = $this->schemas[$schema];
        }
 
        /**
         * This line checks to make sure they have the exact same number
         * of properties. However it makes it difficult to know WHICH ONES
         * are extra, so it's left commented out.
         */
        //$this->assertEquals(count($schema['properties']), count($inspect));

        if ($array) {
            if (!count($inspect)) {
                // $this->markTestSkipped('Results returned from the API contained'
                //         .' no content from: '.$path);
            }

            $inspect = $inspect[0];
        }

        if (is_array($inspect)) {
            if (!count($inspect)) {
                echo "\n\t\t".'Skipped due to empty response';
                return false;
            }

            try {
                foreach ($schema['properties'] as $property => $specs) {
                    if (!array_key_exists($property, $inspect)) {
                        $this->fail('Failed asserting that the schema property'.
                            ' '.$property.' was present in the API response '.
                            'from '.$path.': '.var_dump($inspect));
                    }

                    $type = is_array($specs) ? $specs['type'] : $specs;
                    $type = strip_tags($type);

                    $this->assertSchemaProperty($property, $type, $inspect[$property]);

                    // $this->assertEquals(
                    //     $property.' is a '.$this->translateType($type),
                    //     $property.' is a '.$this->getReturnType(
                    //         $type,
                    //         $inspect[$property]
                    //     )
                    // );
                    if ($type == 'object' && array_key_exists(
                        'properties',
                        $specs
                    )) {
                        $this->subSchemaTest($specs, $inspect[$property]);
                    }
                }
            } catch (\Exception $ex) {
                throw $ex;
            }

            foreach ($inspect as $property => $value) {
                try {
                    $this->assertNotNull($schema['properties'][$property]);
                } catch (\Exception $ex) {
                    $this->fail('Object returned by API had '.$property.' but '.
                    'that property is not part of the Schema (from '.$path.')');
                }
            }
        }
    }

    /**
     * Assert a schema property
     *
     * @param string $property The property to assert
     * @param string $expected What the property should be
     * @param string $actual   What the property actually is
     *
     * @return void
     */
    protected function assertSchemaProperty($property, $expected, $actual)
    {
        $expected = $this->translateType($expected);
        $actual = $this->getReturnType($expected, $actual);

        if ($expected !== $actual) {
            $this->fail('Failed asserting that the API response property \''.
                $property.'\' is'.
                        ' of expected type '.$expected.'. '.$property.' was '.$actual);
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

        if ($expected == 'boolean' && gettype($property) === 'integer') {
            if (in_array($property, [
                0, 1
            ])) {
                return $expected;
            }
        }

        if ($expected == 'object' || $expected == 'array' || $expected == 'object or array') {
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
