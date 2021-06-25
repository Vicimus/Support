<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

/**
 * Class AssetModel
 *
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
     * @return Relation|Placeholderable
     */
    public function assetable();

    /**
     * Get the format we can render this item in (png, jpg, html, pdf)
     *
     * @return string
     */
    public function format(): string;

    /**
     * Get the height of the asset
     * @return int
     */
    public function height(): int;

    /**
     * Get an identifier for this asset. PURLs do not need an identifier
     * as the identifier is what is used to get to the PURL.
     *
     * @return Identifiable
     */
    public function identifier(): Identifiable;

    /**
     * The intent of the Asset, conquest|retention
     * @return string
     */
    public function intent(): string;

    /**
     * Touch the timestamps
     *
     * @return void
     */
    public function touch();

    /**
     * Get the width of the asset
     * @return int
     */
    public function width(): int;
}
