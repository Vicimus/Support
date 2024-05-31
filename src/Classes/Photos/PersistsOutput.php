<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\Photos;

/**
 * Trait PersistsOutput
 *
 * @property string $previous
 */
trait PersistsOutput
{
    /**
     * Persist the last output so it remains on the screen
     *
     * @param string $method The method to use for output
     *
     */
    public function persist(string $method = 'comment'): self
    {
        if (!property_exists($this, 'previous')) {
            return $this;
        }

        $this->$method($this->previous);
        return $this;
    }
}
