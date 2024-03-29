<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Filtering;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Vicimus\Support\Interfaces\Eloquent;

/**
 * Customer Association job interface
 * @property int bumper_id
 * @property bool $complete
 * @property bool $cancelled
 * @property Campaign $campaign
 */
interface CustomerAssociation extends Eloquent
{
    /**
     * The campaign the job is for
     *
     * @return BelongsTo
     */
    public function campaign(): BelongsTo;

    /**
     * Who initiated the association
     * @return string|int|null
     */
    public function createdBy();

    /**
     * Refresh
     * @return string|int|bool
     */
    public function refresh();
}
