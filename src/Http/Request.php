<?php

declare(strict_types=1);

namespace Vicimus\Support\Http;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request as IllRequest;
use Throwable;

use function is_array;

class Request
{
    /** Used to detect complex queries */
    private const COMPLEX_INDICATORS = ['gt:', 'in:', 'lt:'];

    /**
     * Handlers to execute against different operations
     * @var callable[]
     */
    protected array $handlers = [];

    /**
     * An instance of the Illuminate Request which is where we'll
     * get most of our information from
     */
    protected IllRequest $request;

    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     *
     * @param IllRequest|mixed[][] $request Illuminate request instance
     */
    public function __construct(IllRequest | array $request)
    {
        if (is_array($request)) {
            $request = new IllRequest($request);
        }

        $this->request = $request;
    }

    /**
     * Get all parameters
     *
     * @return string[]
     */
    public function all(): array
    {
        return $this->request->except(['with', 'fields', 'limit', 'page']);
    }

    /**
     * Add some special behaviour to a specific request
     */
    public function bind(string $operation, callable $modifier): self
    {
        if (!array_key_exists($operation, $this->handlers)) {
            $this->handlers[$operation] = [];
        }

        $this->handlers[$operation][] = $modifier;
        return $this;
    }

    /**
     * Get everything except the provided properties from the request
     *
     * @param string|string[] $properties The properties to exclude
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     * @return mixed[]
     */
    public function except(string | array $properties): array
    {
        if (!is_array($properties)) {
            $properties = [$properties];
        }

        return $this->request->except($properties);
    }

    /**
     * Get a specific property
     */
    public function get(string $property, mixed $default = null, ?string $cast = null): mixed
    {
        $value = $this->request->get($property, $default);
        if ($cast === null || $value === null) {
            return $value;
        }

        return $this->cast($value, $cast);
    }

    /**
     * Check if the request has a param
     */
    public function has(string $property): bool
    {
        return $this->request->has($property);
    }

    /**
     * Checks for key aspects that may indicate this is a 'complex query'
     */
    public function isComplexQuery(): bool
    {
        foreach ($this->request->all() as $value) {
            if ($this->checkForComplex($value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Order by which column
     *
     * @return string[]
     */
    public function orderBy(): array
    {
        if (!$this->request->has('orderBy')) {
            return ['id', 'asc'];
        }

        $parts = explode(':', $this->request->get('orderBy'));
        if (count($parts) >= 2) {
            return $parts;
        }

        return [$parts[0], 'asc'];
    }

    /**
     * Build a query based on the request
     *
     * @param Builder  $builder         The builder object
     * @param string[] $mandatorySelect Things we have to select no matter what
     */
    public function query(Builder $builder, array $mandatorySelect = []): Builder
    {
        $query = $builder->select(array_merge($this->select(), $mandatorySelect))
            ->with($this->with());

        if ($this->has('orderBy')) {
            $order = $this->orderBy();
            $query->orderBy($order[0], $order[1]);
        }

        return $query;
    }

    /**
     * Get the columns to select based on the request
     *
     * @return string[]
     */
    public function select(): array
    {
        return explode(',', $this->request->get('fields', '*') ?? '*');
    }

    /**
     * Retrieve the illuminate request object
     */
    public function toRequest(): IllRequest
    {
        return $this->request;
    }

    /**
     * Get the with values
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     *
     * @return mixed[]
     */
    public function with(mixed ...$default): array
    {
        if (!$this->request->has('with')) {
            return $default;
        }

        if ($this->request->get('with') === 'null') {
            return [];
        }

        return explode(',', $this->request->get('with', '') ?? '');
    }

    /**
     * Cast the provided property to its type
     */
    private function cast(mixed $value, string $cast): mixed
    {
        try {
            settype($value, $cast);
        } catch (Throwable $ex) {
            return $value;
        }

        return $value;
    }

    /**
     * Check for a complex string
     */
    private function checkForComplex(mixed $value): bool
    {
        foreach (self::COMPLEX_INDICATORS as $check) {
            if (strpos((string) $value, $check) !== false) {
                return true;
            }
        }

        return false;
    }
}
