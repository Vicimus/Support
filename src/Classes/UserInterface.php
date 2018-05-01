<?php declare(strict_types = 1);

namespace Vicimus\Support;

/**
 * Declares information about a UI package
 *
 * @property string[] $dependencies
 * @property string[] $public
 */
class UserInterface
{
    /**
     * Node dependencies
     *
     * @var string[]
     */
    protected $dependencies = [];

    /**
     * Public dependencies
     *
     * @var string[]
     */
    protected $public = [];

    /**
     * Get a protected property
     *
     * @param string $property The property to get
     *
     * @return mixed
     */
    public function __get(string $property)
    {
        return $this->$property;
    }

    /**
     * Parse node dependencies
     *
     * @param string $path The path to the package.json file to parse
     *
     * @return string[]
     */
    public function parseNodeDependencies(string $path): array
    {
        $node = json_decode(file_get_contents($path), true);
        if (array_key_exists('dependencies', $node)) {
            $this->dependencies = $node['dependencies'];
        }

        return $this->dependencies;
    }

    /**
     * Declare any public dependencies that should be moved into the
     * public folder. These MUST be present in your Node Dependencies,
     * but are only the various min files you are including in markup.
     *
     * @param string[] $dependencies Any dependencies to declare
     *
     * @return string[]
     */
    public function publicDependencies(array $dependencies): array
    {
        $this->public = $dependencies;
        return $this->public;
    }
}
