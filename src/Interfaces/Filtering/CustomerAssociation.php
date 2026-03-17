<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Filtering;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Vicimus\Support\Interfaces\Eloquent;

/**
 * @property int bumper_id
 * @property bool $complete
 * @property bool $cancelled
 * @property Campaign $campaign
 */
interface CustomerAssociation extends Eloquent
{
    /**
     * The campaign the job is for
     */
    public function campaign(): BelongsTo;

    /**
     * Who initiated the association
     */
    public function createdBy(): string | int | null;

    /**
     * Refresh - This is not type hinted properly because it's actually an Eloquent method
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint
     * @return string|int|bool
     */
    public function refresh();
}
