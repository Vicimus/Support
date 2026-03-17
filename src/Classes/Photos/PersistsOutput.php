<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\Photos;

/**
 * @property string $previous
 */
trait PersistsOutput
{
    /**
     * Persist the last output so it remains on the screen
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
