<?php
/**
 * File src/AbstractConfigB.php
 *
 * Type B configuration.
 *
 * @package saprfc-koucky
 * @author  Gregor J.
 * @license MIT
 */

namespace phpsap\classes;

use phpsap\interfaces\IConfigB;

/**
 * Class phpsap\classes\AbstractConfigB
 *
 * Abstract class to configure connection parameters for SAP remote function calls
 * using load balancing (type B).
 *
 * @package phpsap\classes
 * @author  Gregor J.
 * @license MIT
 */
abstract class AbstractConfigB extends AbstractConfig implements IConfigB
{
    /**
     * Get the name of SAP system, optional; default: destination
     * @return string name of SAP system.
     */
    public function getR3name()
    {
        return $this->config['r3name'];
    }

    /**
     * Get the host name of the message server.
     * @return string host name of the message server
     */
    public function getMshost()
    {
        return $this->config['mshost'];
    }

    /**
     * Get the group name of the application servers, optional; default: PUBLIC.
     * @return string group name of the application servers
     */
    public function getGroup()
    {
        return $this->config['group'];
    }
}
