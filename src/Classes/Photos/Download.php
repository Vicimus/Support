<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes\Photos;

use Vicimus\Support\Classes\ImmutableObject;
use Vicimus\Support\Interfaces\Vehicle;

/**
 * Class Download
 *
 * @property Stock $stock
 * @property PhotoStatus $status
 */
class Download extends ImmutableObject implements Downloadable
{
    /**
     * Download constructor
     *
     * @param Vehicle     $vehicle The stock this will be for
     * @param PhotoStatus $status  The photo status
     */
    public function __construct(Vehicle $vehicle, PhotoStatus $status)
    {
        parent::__construct([
            'vehicle' => $vehicle,
            'status' => $status,
        ]);
    }

    /**
     * Must return a photo status object
     *
     * @return PhotoStatus
     */
    public function status(): PhotoStatus
    {
        return $this->attributes['status'];
    }

    /**
     * Must return the vehicle this download is associated with
     *
     * @return Vehicle
     */
    public function vehicle(): Vehicle
    {
        return $this->attributes['vehicle'];
    }
}
