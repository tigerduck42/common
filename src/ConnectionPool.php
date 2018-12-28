<?php
/**
 * File src/ConnectionPool.php
 *
 * PHP/SAP connection pool.
 *
 * @package common
 * @author  Gregor J.
 * @license MIT
 */

namespace phpsap\classes;

use phpsap\exceptions\ConnectionNotFoundException;
use phpsap\interfaces\IConnection;

/**
 * Class phpsap\classes\ConnectionPool
 *
 * Provides a static pool of available PHP/SAP connections. The connections are
 * organized using their connection IDs.
 *
 * @package phpsap\classes
 * @author  Gregor J.
 * @license MIT
 */
class ConnectionPool
{
    /**
     * @var array
     */
    private static $connections = [];

    /**
     * Determine whether given connection ID is valid or not.
     * @param $connectionId
     * @throws \InvalidArgumentException
     */
    private static function validateConnectionId($connectionId)
    {
        if ((!is_int($connectionId) && !is_string($connectionId))
            || trim($connectionId) === ''
        ) {
            throw new \InvalidArgumentException(
                'Expected connection ID to be either string or integer.'
            );
        }
    }

    /**
     * Determine whether a connection using the given connection ID already exists.
     * @param int|string $connectionId
     * @return bool
     * @throws \InvalidArgumentException
     */
    public static function has($connectionId)
    {
        static::validateConnectionId($connectionId);
        return array_key_exists($connectionId, static::$connections);
    }

    /**
     * Get the connection with the given connection ID.
     * @param int|string $connectionId
     * @return \phpsap\interfaces\IConnection
     * @throws \InvalidArgumentException
     * @throws \phpsap\exceptions\ConnectionNotFoundException
     */
    public static function get($connectionId)
    {
        if (!static::has($connectionId)) {
            throw new ConnectionNotFoundException(sprintf(
                'Connection ID \'%s\' does not exist.',
                $connectionId
            ));
        }
        return static::$connections[$connectionId];
    }

    /**
     * Set the connection using the given connection ID.
     * @param int|string $connectionId
     * @param \phpsap\interfaces\IConnection $connection
     * @throws \InvalidArgumentException
     */
    public static function add($connectionId, IConnection $connection)
    {
        static::validateConnectionId($connectionId);
        if (!static::has($connectionId)) {
            static::$connections[$connectionId] = $connection;
        }
    }

    /**
     * Remove a connection.
     * @param int|string $connectionId
     * @throws \InvalidArgumentException
     */
    public static function remove($connectionId)
    {
        static::validateConnectionId($connectionId);
        if (static::has($connectionId)) {
            unset(static::$connections[$connectionId]);
        }
    }

    /**
     * Remove all connections.
     */
    public static function clear()
    {
        foreach (array_keys(static::$connections) as $connectionId) {
            static::remove($connectionId);
        }
    }
}
