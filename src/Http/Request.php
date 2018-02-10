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
        return $this->request->except(['with', 'fields']);
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
     * Build a query based on the request
     *
     * @param Builder $builder The builder object
     *
     * @return Builder
     */
    public function query(Builder $builder): Builder
    {
        return $builder->select($this->select())
            ->with($this->with());
    }

    /**
     * Get the columns to select based on the request
     *
     * @return string[]
     */
    public function select(): array
    {
        $fields = explode(',', $this->request->get('fields', '*'));
        return $fields;
    }

    /**
     * Get the with values
     *
     * @return string[]
     */
    public function with(): array
    {
        $with = explode(',', $this->request->get('with', ''));
        return $with;
    }
}
