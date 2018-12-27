<?php
/**
 * File tests/helper/Config.php
 *
 * Config class for testing.
 *
 * @package common
 * @author  Gregor J.
 * @license MIT
 */

namespace tests\phpsap\classes\helper;

use phpsap\classes\AbstractConfig;

/**
 * Class tests\phpsap\classes\helper\Config
 *
 * Helper class extending the abstract config class for testing only.
 *
 * @package tests\phpsap\classes\helper
 * @author  Gregor J.
 * @license MIT
 */
class Config extends AbstractConfig
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
}
