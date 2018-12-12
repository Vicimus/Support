<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Filtering;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Vicimus\Support\Interfaces\Eloquent;

/**
 * Customer Association job interface
 * @property int bumper_id
 * @property boolean $complete
 * @property boolean $cancelled
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
}
