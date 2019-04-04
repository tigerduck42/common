<?php
/**
 * File exceptions/ConnectionFailedException.php
 *
 * PHP/SAP connection failed.
 *
 * @package exceptions
 * @author  Gregor J.
 * @license MIT
 */

namespace phpsap\exceptions;

use phpsap\interfaces\exceptions\IConnectionFailedException;

/**
 * Class ConnectionFailedException
 *
 * Exception thrown when PHP/SAP connections fail.
 *
 * @package phpsap\exceptions
 * @author  Gregor J.
 * @license MIT
 */
class ConnectionFailedException extends SapException implements IConnectionFailedException
{
}
