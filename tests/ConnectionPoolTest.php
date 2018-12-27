<?php
/**
 * File tests/ConnectionPoolTest.php
 *
 * Test the static connection pool.
 *
 * @package common
 * @author  Gregor J.
 * @license MIT
 */

namespace tests\phpsap\classes;

use phpsap\classes\ConnectionPool;
use tests\phpsap\classes\helper\ConfigA;
use tests\phpsap\classes\helper\Connection;

/**
 * Class tests\phpsap\classes\ConnectionPoolTest
 *
 * Test the static connection pool.
 *
 * @package tests\phpsap\classes
 * @author  Gregor J.
 * @license MIT
 */
class ConnectionPoolTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test basic add-, has-, remove-functionality.
     */
    public function testAddHasRemove()
    {
        static::assertFalse(ConnectionPool::has('vtRqbUjj'));
        ConnectionPool::add('vtRqbUjj', new Connection(new ConfigA()));
        static::assertTrue(ConnectionPool::has('vtRqbUjj'));
        $connection = ConnectionPool::get('vtRqbUjj');
        static::assertInstanceOf(Connection::class, $connection);
        ConnectionPool::remove('vtRqbUjj');
        static::assertFalse(ConnectionPool::has('vtRqbUjj'));
    }

    /**
     * Test clearing the connection pool.
     */
    public function testClearingConnectionPool()
    {
        static::assertFalse(ConnectionPool::has('5leMzoep'));
        ConnectionPool::add('5leMzoep', new Connection(new ConfigA()));
        static::assertTrue(ConnectionPool::has('5leMzoep'));
        ConnectionPool::clear();
        static::assertFalse(ConnectionPool::has('5leMzoep'));
    }

    /**
     * Data provider for invalid connection IDs.
     * @return array
     */
    public static function invalidConnectionIds()
    {
        return [
            [''],
            ["\0"],
            [7.67],
            [true],
            [false],
            [null],
            [[]],
            [new \stdClass()]
        ];
    }

    /**
     * Test invalid connection IDs using has().
     * @param mixed $connectionId
     * @dataProvider invalidConnectionIds
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected connection ID to be either string or integer.
     */
    public function testHasInvalidConnectionId($connectionId)
    {
        ConnectionPool::has($connectionId);
    }
}
