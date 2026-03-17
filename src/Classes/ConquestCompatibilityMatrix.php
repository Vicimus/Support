<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

use Illuminate\Contracts\View\View;
use ReflectionClass;
use ReflectionException;
use Vicimus\Support\Interfaces\MarketingSuite\ConquestDataSource;
use Vicimus\Support\Interfaces\MarketingSuite\ConquestDataSourceRepository;

/**
 * @property ConquestCompatibility[] $matrix
 */
class ConquestCompatibilityMatrix extends ImmutableObject
{
    /**
     * @param string[][]|string[] $matrix
     */
    public function __construct(
        array $matrix = [],
    ) {
        parent::__construct([
            'matrix' => [],
        ]);

        if (!count($matrix)) {
            return;
        }

        $this->add($matrix);
    }

    /**
     * Add some compatibility information
     *
     * @param string[][]|string[] $matrix The matrix
     */
    public function add(array $matrix): void
    {
        $rows = [];
        foreach ($matrix as $source => $description) {
            if (!$this->isValidSource($source)) {
                continue;
            }

            $rows[] = new ConquestCompatibility($source, $this->render($description));
        }

        $this->attributes['matrix'] = array_merge($this->attributes['matrix'], $rows);
    }

    /**
     * @return ConquestCompatibilityMatrix[]
     */
    public function toArray(): array
    {
        return $this->attributes['matrix'];
    }

    /**
     * Check if a source is valid
     */
    private function isValidSource(string $source): bool
    {
        try {
            $class = new ReflectionClass($source);
        } catch (ReflectionException $ex) {
            return false;
        }

        $registrar = app(ConquestDataSourceRepository::class);
        if (!$registrar->isRegistered($source)) {
            return false;
        }

        return !$class->isAbstract() || !$class->implementsInterface(ConquestDataSource::class);
    }

    /**
     * Render or just return the string
     */
    private function render(View | string $description): string
    {
        if ($description instanceof View) {
            $description = $description->render();
        }

        return $description;
    }
}
