<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Glovebox;

/**
 * Interface for a models change log methods.
 */
interface ChangeLoggable
{
    /**
     * Retrieve the output for a model in the change log.
     *
     * @return mixed[]|mixed
     */
    public function getChangeHeader();
}
