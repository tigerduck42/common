<?php
/**
 * File src/AbstractConnection.php
 *
 * PHP/SAP connection class.
 *
 * @package common
 * @author  Gregor J.
 * @license MIT
 */

namespace phpsap\classes;

use phpsap\interfaces\IConfig;
use phpsap\interfaces\IConnection;

/**
 * Class phpsap\classes\AbstractConnection
 *
 * Abstract class to manage a single PHP/SAP connection.
 *
 * @package phpsap\classes
 * @author  Gregor J.
 * @license MIT
 */
abstract class AbstractConnection implements IConnection
{
    /**
     * @var int number of retries, when establishing a connection.
     */
    const RETRIES = 1;

    /**
     * @var int number of seconds to wait before connection retry.
     */
    const RETRY_WAIT = 1;

    /**
     * @var mixed SAP remote connection.
     */
    protected $connection;

    /**
     * @var array Configuration array.
     */
    protected $config;

    /**
     * @var string SapRfcConnection ID.
     */
    protected $id;

    /**
     * Initialize this class with a configuration.
     * @param \phpsap\interfaces\IConfig $config
     */
    public function __construct(IConfig $config)
    {
        $this->config = $config->generateConfig();
    }

    /**
     * Returns the connection ID.
     * The connection ID is derived from the configuration. The same configuration
     * will result in the same connection ID.
     * @return string
     */
    public function getId()
    {
        if ($this->id === null) {
            $this->id = md5(serialize($this->config));
        }
        return $this->id;
    }

    /**
     * Is connection established?
     * @return bool
     */
    public function isConnected()
    {
        return $this->connection !== null;
    }

    /**
     * Returns the actual connection ressource.
     * @return mixed SAPRFC connection instance
     * @throws \phpsap\exceptions\ConnectionFailedException
     */
    protected function getConnection()
    {
        $trials = 0;
        do {
            if ($this->ping()) {
                return $this->connection;
            }
            $trials++;
            sleep(static::RETRY_WAIT);
        } while ($trials < static::RETRIES);
        //give up
        throw new \phpsap\exceptions\ConnectionFailedException(sprintf(
            'Connection %s failed after %u retries.',
            $this->getId(),
            static::RETRIES
        ));
    }

    /**
     * Send a ping request via an established connection to verify that the
     * connection works.
     * @return boolean success?
     * @throws \phpsap\exceptions\ConnectionFailedException
     */
    abstract public function ping();

    /**
     * Closes the connection instance of the underlying PHP module.
     */
    abstract public function close();

    /**
     * Prepare a remote function call and return a function instance.
     * @param string $name
     * @return \phpsap\classes\AbstractFunction
     * @throws \phpsap\exceptions\ConnectionFailedException
     * @throws \phpsap\exceptions\UnknownFunctionException
     */
    abstract public function prepareFunction($name);
}
