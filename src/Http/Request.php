<?php declare(strict_types = 1);

namespace Vicimus\Support\Http;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request as IllRequest;

/**
 * Class Request
 */
class Request
{
    /**
     * Handlers to execute against different operations
     *
     * @var callable[]
     */
    protected $handlers = [];

    /**
     * An instance of the Illuminate Request which is where we'll
     * get most of our information from
     *
     * @var IllRequest
     */
    protected $request;

    /**
     * Request constructor
     *
     * @param IllRequest $request Illuminate request instance
     */
    public function __construct(IllRequest $request)
    {
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
     *
     * @param string   $operation The operation
     * @param callable $modifier  The modifier
     *
     * @return Request
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
     * Get a specific property
     *
     * @param string $property The property to get
     * @param mixed  $default  The default
     *
     * @return mixed
     */
    public function get(string $property, $default = null)
    {
        return $this->request->get($property, $default);
    }

    /**
     * Check if the request has a param
     *
     * @param string $property The property to check
     *
     * @return bool
     */
    public function has(string $property): bool
    {
        return $this->request->has($property);
    }

    /**
     * Order by which column
     *
     * @return string[]
     */
    public function orderBy(): array
    {
        $parts = explode(':', $this->request->get('orderBy'));
        if (count($parts) >= 2) {
            return $parts;
        }

        return [$parts[0], 'asc'];
    }

    /**
     * Build a query based on the request
     *
     * @param Builder $builder The builder object
     *
     * @return Builder
     */
    public function query(Builder $builder): Builder
    {
        $query = $builder->select($this->select())
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
        $fields = explode(',', $this->request->get('fields', '*') ?? '*');
        return $fields;
    }

    /**
     * Get the with values
     *
     * @param mixed ...$default The default with
     *
     * @return mixed[]
     */
    public function with(...$default): array
    {
        if (!$this->request->has('with')) {
            return $default;
        }

        if ($this->request->get('with') === 'null') {
            return [];
        }

        $with = explode(',', $this->request->get('with', '') ?? '*');
        return $with;
    }
}
