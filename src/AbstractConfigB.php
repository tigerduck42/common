<?php
/**
 * File src/AbstractConfigB.php
 *
 * Type B configuration.
 *
 * @package common
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
        return $this->get('r3name');
    }

    /**
     * Set the r3name.
     * @param string $value
     */
    protected function setR3name($value)
    {
        $this->set('r3name', (string)$value);
    }

    /**
     * Get the host name of the message server.
     * @return string host name of the message server
     */
    public function getMshost()
    {
        return $this->get('mshost');
    }

    /**
     * Set the mshost.
     * @param string $value
     */
    protected function setMshost($value)
    {
        $this->set('mshost', (string)$value);
    }

    /**
     * Get the group name of the application servers, optional; default: PUBLIC.
     * @return string group name of the application servers
     */
    public function getGroup()
    {
        return $this->get('group');
    }

    /**
     * Set the group.
     * @param string $value
     */
    protected function setGroup($value)
    {
        $this->set('group', (string)$value);
    }
}
