<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Vicimus\Support\Classes\AutocompleteItem;

/**
 * Interface ConquestSearchHandler
 */
interface ConquestSearchHandler
{
    /**
     * Search for a term
     *
     * @param string $term The term to search for
     *
     * @return AutocompleteItem[]
     */
    public function search(string $term): array;
}
