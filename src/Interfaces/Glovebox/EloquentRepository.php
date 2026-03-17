<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox;

interface EloquentRepository
{
    /**
     * Create a new type record
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint
     *
     * @param mixed[] $attributes The attributes
     *
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * Get the type by id
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint
     *
     * @param int $id The id of the type to get
     *
     * @return mixed|null
     */
    public function find(int $id);

    /**
     * Find or create
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint
     *
     * @param mixed[] $attributes The attributes
     *
     * @return mixed
     */
    public function firstOrCreate(array $attributes);
}
