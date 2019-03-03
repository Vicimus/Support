<?php declare(strict_types = 1);

namespace Vicimus\Support\Services;

use Vicimus\Support\Interfaces\ClassRepository;

use function is_array;

/**
 * Class BaseClassRepository
 */
class BaseClassRepository implements ClassRepository
{
    /**
     * The repo of class names
     *
     * @var string[]
     */
    private $repo = [];

    /**
     * Register one or many data services
     *
     * @param string|string[] $classes Register one or many data sources
     *
     * @return void
     */
    public function register($classes): void
    {
        $this->repo = array_merge($this->repo, (array) $classes);
    }
}
