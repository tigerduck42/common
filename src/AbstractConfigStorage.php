<?php
/**
 * File src/AbstractConfigStorage.php
 *
 * Simple storage of configuration keys and values.
 *
 * @package common
 * @author  Gregor J.
 * @license MIT
 */

namespace phpsap\classes;

use InvalidArgumentException;
use LogicException;
use phpsap\exceptions\ConfigKeyNotFoundException;
use Serializable;

/**
 * Class AbstractConfigStorage
 *
 * Simple storage of PHP/SAP configuration keys and values.
 *
 * @package phpsap\classes
 * @author  Gregor J.
 * @license MIT
 */
abstract class AbstractConfigStorage implements Serializable
{
    /**
     * @var array The configuration data.
     */
    protected $config = [];

    /**
     * Constructor optionally loads the configuration from an array.
     * @param array $config The configuration array
     * @throws \InvalidArgumentException
     */
    public function __construct($config = null)
    {
        if (is_array($config)) {
            $this->loadArray($config);
        } elseif ($config !== null) {
            throw new InvalidArgumentException(
                'Expected configuration to be an array!'
            );
        }
    }

    /**
     * Load configuration array.
     *
     * Process each key of the array and determine whether a set method exists for
     * the given key.
     *
     * @param array $config
     * @throws \InvalidArgumentException
     */
    protected function loadArray($config)
    {
        foreach ($config as $key => $value) {
            /**
             * Compile the name of the set method in PSR-2 compatible format. The
             * key has to be lower case (uSer -> user) and then only the first char
             * is upper case (user -> User). The resulting method name would be
             * setUser.
             */
            $method = sprintf('set%s', ucfirst(strtolower($key)));
            if (method_exists($this, $method)) {
                $this->{$method}($value);
            }
            /**
             * No exception is thrown in case of invalid function names. That way
             * only recognized keys are imported and the rest is simply ignored.
             */
        }
    }

    /**
     * Sets a configuration value.
     * @param string $key
     * @param string|int|float|bool $value
     * @throws \LogicException In case you (the developer) didn't use a non-empty string as key.
     * @throws \InvalidArgumentException In case the value is no string, float, int or bool.
     */
    protected function set($key, $value)
    {
        if (!is_string($key) || empty($key)) {
            throw new LogicException(
                'Expected configuration key to be a string value.'
            );
        }
        if (!is_string($value) && !is_int($value) && !is_float($value) && !is_bool($value)) {
            throw new InvalidArgumentException(
                'Expected configuration value to be either a'
                .' string, floating point, integer or boolean value.'
            );
        }
        $this->config[$key] = $value;
    }

    /**
     * Retrieves a configuration value by its key.
     * @param string $key Configuration key to look for.
     * @return string|bool|int Configuration value.
     * @throws \phpsap\exceptions\ConfigKeyNotFoundException No entry was found for this identifier.
     * @throws \LogicException In case you (the developer) provided an empty string as key.
     */
    protected function get($key)
    {
        if (!$this->has($key)) {
            throw new ConfigKeyNotFoundException(sprintf(
                'No entry was found for configuration key \'%s\'.',
                $key
            ));
        }
        return $this->config[$key];
    }

    /**
     * Determines whether a configuration key exists.
     * @param string $key Configuration key to look for.
     * @return bool
     * @throws \LogicException In case you (the developer) provided an empty string as key.
     */
    protected function has($key)
    {
        if (!is_string($key) || empty($key)) {
            throw new LogicException(
                'Expected configuration key to be a string value.'
            );
        }
        return array_key_exists($key, $this->config);
    }

    /**
     * String representation of object
     * @link  https://php.net/manual/en/serializable.serialize.php
     * @return string The string representation of the object or null.
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize($this->config);
    }

    /**
     * Constructs the object
     * @link  https://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized The string representation of the object.
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        $payload = unserialize($serialized);
        if (!is_array($payload)) {
            $this->loadArray($payload);
        }
    }
}
