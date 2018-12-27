<?php
/**
 * File tests/helper/ConfigContainer.php
 *
 * Config container class for testing.
 *
 * @package common
 * @author  Gregor J.
 * @license MIT
 */

namespace tests\phpsap\classes\helper;

use phpsap\classes\AbstractConfigContainer;

/**
 * Class tests\phpsap\classes\helper\ConfigContainer
 *
 * Helper class extending the abstract config container class for testing only.
 *
 * @package tests\phpsap\classes\helper
 * @author  Gregor J.
 * @license MIT
 */
class ConfigContainer extends AbstractConfigContainer
{
    /**
     * Generate the type of configuration needed by the PHP module in order to
     * establish a connection to SAP.
     * @return mixed
     */
    public function generateConfig()
    {
        return $this->jsonSerialize();
    }

    /**
     * Make protected function public for testing.
     * Loads configuration from a JSON string.
     * @param string $config
     * @throws \InvalidArgumentException
     */
    public function loadJsonString($config)
    {
        parent::loadJsonString($config);
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
     * Define one setter method for testing.
     * @param mixed $value
     */
    protected function setQvypepzo($value)
    {
        $this->set('qvypepzo', $value);
    }
}
