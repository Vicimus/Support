<?php declare(strict_types = 1);

namespace Vicimus\Support\Testing;

/**
 * Trait SmartAssertions
 */
trait SmartAssertions
{
    /**
     * Filter the file path
     *
     * @var callable
     */
    protected $filterFilePath;

    /**
     * Assert successful response, and print the response if
     * it wasn't successful.
     *
     * @param mixed $response The response from the request
     *
     * @return mixed
     */
    public function assertStatusOk($response)
    {
        $code = $response->getStatusCode();
        if ($code !== 200) {
            $body = $response->getContent();
            $decoded = json_decode($body, true);
            if (!$decoded) {
                $decoded = $body;
            }

            $message = $this->generateMessageFromError($decoded);
            $this->fail($message);
        }

        $this->assertEquals(200, $code);
        return json_decode($response->getContent());
    }

    /**
     * Pass the file path through a filter before returning it
     *
     * @param callable $filter The callable to apply
     *
     * @return self
     */
    public function filterFilePath(callable $filter): self
    {
        $this->filterFilePath = $filter;
        return $this;
    }

    /**
     * Generate a user friendly message from an error
     *
     * @param mixed $response The response from the server
     *
     * @return string
     */
    private function generateMessageFromError($response): string
    {
        if (!is_array($response)) {
            return "\033[1;31m".$response."\033[0m";
        }

        if (!isset($response['error'])) {
            return json_encode($response);
        }

        if (isset($response['error']) && !isset($response['type'], $response['file'], $response['line'])) {
            return "\033[1;31m".$response['error']."\033[0m";
        }

        $file = $response['file'];
        if ($this->filterFilePath) {
            $method = $this->filterFilePath;
            $file = $method($file);
        }

        return '['."\033[31m".$response['type']."\033[0m".'] encountered'.
            ' on line ['."\033[35m".$response['line']."\033[0m".'] of '.PHP_EOL.
            '['."\033[1;34m".$file."\033[0m".'] with message: '.PHP_EOL.PHP_EOL.
            "\033[1;31m".$response['error']."\033[0m";
    }
}
