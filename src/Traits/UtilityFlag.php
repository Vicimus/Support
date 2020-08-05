<?php declare(strict_types = 1);

namespace Vicimus\Support\Traits;

/**
 * Trait for adding flags to a utilities command.
 */
trait UtilityFlag
{
    /**
     * Add flags to a utility
     *
     * Used by the utility manager to allow specific flags to be triggered when
     * the command is run.
     *
     * @param string[]|mixed $flags The desired flags to add.
     *
     * @return string
     */
    public function addFlags($flags): string
    {
        return view('utility.partials.flags')
            ->with([
                'flags' => $flags,
            ])->render();
    }
}
