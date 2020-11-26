<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

/**
 * Class AssetModel
 *
 * Represents an database model or a fake version of one
 *
 * @property Campaign $campaign
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
     * @return Relation|Campaign
     */
    public function campaign();

    /**
     * Get the format we can render this item in (png, jpg, html, pdf)
     *
     * @return string
     */
    public function format(): string;

    /**
     * Get an identifier for this asset. PURLs do not need an identifier
     * as the identifier is what is used to get to the PURL.
     *
     * @return Identifiable
     */
    public function identifier(): Identifiable;

    /**
     * Touch the timestamps
     *
     * @return void
     */
    public function touch();

    /**
     * @param array $params
     * @return bool
     */
    public function update(array $attributes = [], array $options = []);
}
