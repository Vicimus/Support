<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

use Illuminate\Contracts\View\View;

/**
 * Class ConquestCompatibilityMatrix
 *
 * @property ConquestCompatibility[] $matrix
 */
class ConquestCompatibilityMatrix extends ImmutableObject
{
    /**
     * ConquestCompatibilityMatrix constructor.
     *
     * @param mixed[] $matrix An array of compatibility info
     */
    public function __construct(array $matrix = [])
    {
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
     * @param mixed[] $matrix The matrix
     *
     * @return void
     */
    public function add(array $matrix): void
    {
        $rows = [];
        foreach ($matrix as $source => $description) {
            if ($description instanceof View) {
                $description = $description->render();
            }

            $rows[] = new ConquestCompatibility($source, $description);
        }

        $this->attributes['matrix'] = array_merge($this->attributes['matrix'], $rows);
    }

    /**
     * To array
     *
     * @return ConquestCompatibilityMatrix[]
     */
    public function toArray(): array
    {
        return $this->attributes['matrix'];
    }
}
