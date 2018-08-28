<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes\Photos;

use Vicimus\Support\Classes\API\AsyncRequestPool;
use Vicimus\Support\Interfaces\Vehicle;

/**
 * Class AsyncDownload
 */
class AsyncDownload implements DownloadRequest
{
    /**
     * The async pool
     *
     * @var AsyncRequestPool
     */
    protected $pool;

    /**
     * AsyncDownload constructor.
     *
     * @param AsyncRequestPool $pool The async pool for this
     */
    public function __construct(AsyncRequestPool $pool)
    {
        $this->pool = $pool;
    }

    /**
     * Get the async request pool
     *
     * @return AsyncRequestPool
     */
    public function getAsyncPool(): AsyncRequestPool
    {
        return $this->pool;
    }

    /**
     * Get the single photo status
     *
     * @throws DownloadException
     *
     * @return PhotoStatus
     */
    public function getSinglePhotoStatus(): PhotoStatus
    {
        throw new DownloadException(
            sprintf('Cannot call %s from %s', __METHOD__, get_class($this))
        );
    }

    /**
     * Get the single download vehicle unit
     *
     * @throws DownloadException
     *
     * @return Vehicle
     */
    public function getSingleVehicle(): Vehicle
    {
        throw new DownloadException(
            sprintf('Cannot call %s from %s', __METHOD__, get_class($this))
        );
    }

    /**
     * Is your download request an async request or a single download
     *
     * @return bool
     */
    public function isAsynchronous(): bool
    {
        return true;
    }
}
