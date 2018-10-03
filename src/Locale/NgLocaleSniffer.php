<?php declare(strict_types = 1);

namespace Vicimus\Support\Locale;

use DOMElement;
use Symfony\Component\DomCrawler\Crawler;

use function in_array;

/**
 * Class NgLocaleSniffer
 */
class NgLocaleSniffer
{
    /**
     * Words that are the same in ALL languages
     */
    private const BLACKLIST = [
        'Bumper',
    ];

    /**
     * The messages file
     *
     * @var string
     */
    private $messages;

    /**
     * NgLocaleSniffer constructor.
     *
     * @param null|string $path The path to the file to use
     */
    public function __construct(?string $path)
    {
        $this->messages = $path;
    }

    /**
     * Get missing keys
     *
     * @param string $path The path
     *
     * @return MissingTranslation[]
     */
    public function missing(string $path): array
    {
        $xml = file_get_contents($path);
        $crawler = new Crawler($xml);

        $missing = [];
        foreach ($crawler->filter('trans-unit') as $domElement) {
            /** @var DOMElement $sourceNode */
            $sourceNode = $domElement->getElementsByTagName('source')[0];
            /** @var DOMElement $targetNode */
            $targetNode = $domElement->getElementsByTagName('target')[0];

            $source = $sourceNode->nodeValue;
            $target = $targetNode->nodeValue;

            if ($this->shouldSkip($source, $target)) {
                continue;
            }

            /** @var DOMElement[] $noteNodes */
            $noteNodes = $domElement->getElementsByTagName('note');
            $notes = [];
            foreach ($noteNodes as $note) {
                $from = $note->getAttribute('from');
                $notes[$from] = $note->nodeValue;
            }

            $notes['original'] = trim($source);
            $missing[] = new MissingTranslation($notes);
        }

        return $missing;
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
     * The path to the messages file
     *
     * @return string
     */
    public function path(): string
    {
        return $this->messages;
    }

    /**
     * Should skip
     *
     * @param string $source The source value
     * @param string $target The target value
     *
     * @return bool
     */
    private function shouldSkip(string $source, string $target): bool
    {
        if ($source !== $target) {
            return true;
        }

        if (in_array($source, self::BLACKLIST, false)) {
            return true;
        }

        if (is_numeric($source)) {
            return true;
        }

        return false;
    }
}
