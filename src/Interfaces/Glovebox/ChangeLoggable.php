<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox;

interface ChangeLoggable
{
    /**
     * Retrieve the output for a model in the change log.
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint
     * @return mixed[]|mixed
     */
    public function getChangeHeader();
}
