<?php
/**
 * File tests/helper/ConfigA.php
 *
 * Config class type A for testing.
 *
 * @package common
 * @author  Gregor J.
 * @license MIT
 */

namespace tests\phpsap\classes\helper;

use phpsap\classes\AbstractConfigA;

/**
 * Class tests\phpsap\classes\helper\ConfigA
 *
 * Helper class extending the abstract config class type A.
 *
 * @package tests\phpsap\classes\helper
 * @author  Gregor J.
 * @license MIT
 */
class ConfigA extends AbstractConfigA
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
