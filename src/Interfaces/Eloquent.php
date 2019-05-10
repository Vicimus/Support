<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces;

use Illuminate\Database\Eloquent\Builder;

/**
 * Interface Eloquent
 */
interface Eloquent
{
    /**
     * Get the query object
     *
     * @return Builder|mixed
     */
    public static function query();

    /**
     * Save the model to the database.
     *
     * @param string[] $options The options to pass along
     *
     * @return bool|mixed
     */
    public function save(array $options = []);

    /**
     * Update the model in the database.
     *
     * @param string[] $attributes The attribute updates
     * @param string[] $options    Additional options
     *
     * @return bool|mixed
     */
    public function update(array $attributes = [], array $options = []);
}
