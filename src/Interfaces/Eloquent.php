<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

/**
 * Interface Eloquent
 */
interface Eloquent
{
    /**
     * Load a relation or relations
     *
     * @param string[]|string $relations The relations to load
     *
     * @return self
     *
     * @phpcsSuppress
     */
    public function load(array|string $relations): Eloquent;

    /**
     * Get the query object
     *
     */
    public static function query(): mixed;

    /**
     * Save the model to the database.
     *
     * @param string[] $options The options to pass along
     *
     */
    public function save(array $options = []): mixed;

    /**
     * Update the model in the database.
     *
     * @param string[] $attributes The attribute updates
     * @param string[] $options    Additional options
     *
     */
    public function update(array $attributes = [], array $options = []): mixed;
}
