<?php declare(strict_types = 1);

namespace Vicimus\Support\Locale;

/**
 * Class NgLocaleSniffer
 */
class NgLocaleSniffer
{
    /**
     * The messages file
     *
     * @var string
     */
    private $messages;

    /**
     * Find context for specific keys
     *
     * @param string[] $keys The keys to look for
     *
     * @return string[]
     */
    public function find(array $keys): array
    {
        $context = [];

        return $context;
    }

    /**
     * Parse out keys from a file
     *
     * @param string $path The path to the content to parse from
     *
     * @return string[]
     */
    public function parseKeysFromContent(string $path): array
    {
        $lines = [];
        $content = fopen($path, 'rb');
        while ($line = fgets($content)) {
            $lines[] = trim(str_replace(['Missing translation for message', '"'], '', $line));
        }

        fclose($content);
        return $lines;
    }

    /**
     * Set the path to the messages file
     *
     * @param string $path The path to the messages file
     *
     * @return void
     */
    public function messages(string $path): void
    {
        $this->messages = $path;
    }
}
