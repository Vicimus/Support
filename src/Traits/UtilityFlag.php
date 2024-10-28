<?php

declare(strict_types=1);

namespace Vicimus\Support\Traits;

trait UtilityFlag
{
    /**
     * Add flags to a utility
     *
     * Used by the utility manager to allow specific flags to be triggered when
     * the command is run.
     */
    public function addFlags(mixed $flags): string
    {
        return view('utility.partials.flags')
            ->with([
                'flags' => $flags,
            ])->render();
    }
}
