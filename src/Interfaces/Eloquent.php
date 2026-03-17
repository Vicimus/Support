<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

use Illuminate\Database\Eloquent\Builder;

// phpcs:disable

interface Eloquent
{
    /**
     * @param string[] $relations The relations to load
     *
     * @return Builder
     */
    public function load($relations);

    /**
     * Get the query object
     *
     * @return Builder
     */
    public static function query();

    /**
     * Save the model to the database.
     *
     * @param string[] $options The options to pass along
     *
     * @return bool
     */
    public function save(array $options = []);

    /**
     * Update the model in the database.
     *
     * @param string[] $attributes The attribute updates
     * @param string[] $options    Additional options
     *
     * @return bool
     */
    public function update(array $attributes = [], array $options = []);
}
