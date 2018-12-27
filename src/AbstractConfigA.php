<?php
/**
 * File src/AbstractConfigA.php
 *
 * Type A configuration.
 *
 * @package common
 * @author  Gregor J.
 * @license MIT
 */

namespace phpsap\classes;

use phpsap\interfaces\IConfigA;

/**
 * Class phpsap\classes\AbstractConfigA
 *
 * Abstract class to configure connection parameters for SAP remote function calls
 * using a specific SAP application server (type A).
 *
 * @package phpsap\classes
 * @author  Gregor J.
 * @license MIT
 */
abstract class AbstractConfigA extends AbstractConfig implements IConfigA
{
    /**
     * Get the host name of a specific SAP application server.
     * @return string host name of a specific SAP application server
     */
    public function getAshost()
    {
        return $this->get('ashost');
    }

    /**
     * Set the destination in RfcOpen.
     * @param string $value
     */
    protected function setAshost($value)
    {
        $this->set('ashost', (string)$value);
    }

    /**
     * Get the SAP system number.
     * @return string SAP system number
     */
    public function getSysnr()
    {
        return $this->get('sysnr');
    }

    /**
     * Set the destination in RfcOpen.
     * @param string $value
     */
    protected function setSysnr($value)
    {
        $this->set('sysnr', (string)$value);
    }

    /**
     * optional; default: gateway on application server
     * @return string gateway on application server
     */
    public function getGwhost()
    {
        return $this->get('gwhost');
    }

    /**
     * Set the destination in RfcOpen.
     * @param string $value
     */
    protected function setGwhost($value)
    {
        $this->set('gwhost', (string)$value);
    }

    /**
     * optional; default: gateway on application server
     * @return string gateway on application server
     */
    public function getGwserv()
    {
        return $this->get('gwserv');
    }

    /**
     * Set the destination in RfcOpen.
     * @param string $value
     */
    protected function setGwserv($value)
    {
        $this->set('gwserv', (string)$value);
    }
}
