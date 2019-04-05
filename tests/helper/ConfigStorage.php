<?php
/**
 * File tests/helper/ConfigStorage.php
 *
 * Config storage class for testing.
 *
 * @package common
 * @author  Gregor J.
 * @license MIT
 */

namespace tests\phpsap\classes\helper;

use phpsap\classes\AbstractConfigStorage;

/**
 * Class ConfigStorage
 *
 * Helper class extending the abstract config storage class for testing only.
 *
 * @package tests\phpsap\classes\helper
 * @author  Gregor J.
 * @license MIT
 */
class ConfigStorage extends AbstractConfigStorage
{
    /**
     * Debug function to retrieve the internal configuration
     * @return mixed
     */
    public function debugInternalConfig()
    {
        return json_encode($this->config);
    }

    /**
     * Make protected function public for testing.
     * Sets a configuration value.
     * @param string                $key
     * @param string|int|float|bool $value
     */
    public function set($key, $value)
    {
        parent::set($key, $value);
    }

    /**
     * Make protected function public for testing.
     * Gets a configuration value.
     * @param string $key
     * @return bool|int|string
     */
    public function get($key)
    {
        return parent::get($key);
    }

    /**
     * Make protected function public for testing.
     * Determines if a configuration value exists.
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return parent::has($key);
    }

    /**
     * Define one setter method for testing.
     * @param mixed $value
     */
    protected function setQvypepzo($value)
    {
        $this->set('qvypepzo', $value);
    }

    /**
     * Define one getter method for testing.
     * @return bool|int|string
     */
    public function getQvypepzo()
    {
        return $this->get('qvypepzo');
    }
}
