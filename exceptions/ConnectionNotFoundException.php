<?php
/**
 * File src/ConnectionNotFoundException.php
 *
 * DESCRIPTION
 *
 * @package common
 * @author  Gregor J.
 * @license MIT
 */

namespace phpsap\exceptions;

use Psr\Container\NotFoundExceptionInterface;

/**
 * Class phpsap\exceptions\ConnectionNotFoundException
 *
 * DESCRIPTION
 *
 * @package phpsap\exceptions
 * @author  Gregor J.
 * @license MIT
 */
class ConnectionNotFoundException extends SapException implements NotFoundExceptionInterface
{
}
