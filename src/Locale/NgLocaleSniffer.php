<?php

declare(strict_types=1);

namespace Vicimus\Support\Locale;

use DOMElement;
use Symfony\Component\DomCrawler\Crawler;

use function in_array;

class NgLocaleSniffer
{
    /**
     * Words that are the same in ALL languages
     */
    private const BLACKLIST = [
        'Bumper',
    ];

    private string $messages;

    public function __construct(?string $path)
    {
        $this->messages = $path;
    }

    /**
     * Get missing keys
     * @return MissingTranslation[]
     */
    public function missing(string $path): array
    {
        $xml = file_get_contents($path);
        $crawler = new Crawler($xml);

        $missing = [];
        foreach ($crawler->filter('trans-unit') as $domElement) {
            $id = $domElement->getAttribute('id');

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
            $notes['id'] = $id;
            $instance = new MissingTranslation($notes);
            $missing[$instance->id] = $instance;
        }

        return $missing;
    }

    /**
     * Parse out keys from a file
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

    public function path(): string
    {
        return $this->messages;
    }

    private function shouldSkip(string $source, string $target): bool
    {
        if ($source !== $target) {
            return true;
        }

        // These need to be non-strict because of case sensitivity
        // phpcs:disable
        if (in_array($source, self::BLACKLIST, false)) {
            return true;
        }

        if (is_numeric($source)) {
            return true;
        }

        return false;
    }
}
