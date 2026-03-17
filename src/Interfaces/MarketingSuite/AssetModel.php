<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use DateTime;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * Represents an database model or a fake version of one
 *
 * @property Previewable $campaign
 * @property int $id
 * @property int $height
 * @property int $width
 * @property bool $active
 * @property string $render_path
 * @property string $type
 * @property DateTime $approved_at
 */
interface AssetModel
{
    /**
     * Retrieve the related campaign
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint
     * @return Relation|Placeholderable
     */
    public function assetable();

    /**
     * An asset model has to define what content id its using
     */
    public function contentId(): int;

    /**
     * An asset model has to define its AC external primary key
     */
    public function externalId(): int;

    /**
     * Get the format we can render this item in (png, jpg, html, pdf)
     */
    public function format(): string;

    /**
     * Get the height of the asset
     */
    public function height(): int;

    /**
     * Get an identifier for this asset. PURLs do not need an identifier
     * as the identifier is what is used to get to the PURL.
     */
    public function identifier(): Identifiable;

    /**
     * The intent of the Asset, conquest|retention
     */
    public function intent(): string;

    /**
     * Touch the timestamps
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint
     * @return void
     */
    public function touch();

    /**
     * Get the width of the asset
     */
    public function width(): int;
}
