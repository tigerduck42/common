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
     * Determine whether a connection using the given connection ID already exists.
     * @param int|string $connectionId
     * @return bool
     */
    public static function has($connectionId)
    {
        if (!is_int($connectionId) && !is_string($connectionId)) {
            return false;
        }
        return array_key_exists($connectionId, static::$connections);
    }

    /**
     * Get the connection with the given connection ID.
     * @param int|string $connectionId
     * @return \phpsap\interfaces\IConnection
     * @throws \phpsap\exceptions\ConnectionNotFoundException in case of a non-existing ID
     */
    public static function get($connectionId)
    {
        if (!static::has($connectionId)) {
            throw new ConnectionNotFoundException('Invalid connection ID');
        }
        return static::$connections[$connectionId];
    }

    /**
     * Set the connection using the given connection ID.
     * @param int|string $connectionId
     * @param \phpsap\interfaces\IConnection $connection
     */
    public static function add($connectionId, IConnection $connection)
    {
        if (!static::has($connectionId)) {
            static::$connections[$connectionId] = $connection;
        }
    }

    /**
     * Remove a connection.
     * @param int|string $connectionId
     */
    public static function remove($connectionId)
    {
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
