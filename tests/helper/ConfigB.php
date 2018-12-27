<?php
/**
 * File tests/helper/ConfigB.php
 *
 * Config class type B for testing.
 *
 * @package common
 * @author  Gregor J.
 * @license MIT
 */

namespace tests\phpsap\classes\helper;

use phpsap\classes\AbstractConfigB;

/**
 * Class tests\phpsap\classes\helper\ConfigB
 *
 * Helper class extending the abstract config class type B.
 *
 * @package tests\phpsap\classes\helper
 * @author  Gregor J.
 * @license MIT
 */
class ConfigB extends AbstractConfigB
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
