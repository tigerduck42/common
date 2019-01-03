<?php
/**
 * File exceptions/UnknownFunctionException.php
 *
 * PHP/SAP function not found.
 *
 * @package exceptions
 * @author  Gregor J.
 * @license MIT
 */

namespace phpsap\exceptions;

use phpsap\interfaces\exceptions\IUnknownFunctionException;

/**
 * Class phpsap\exceptions\UnknownFunctionException
 *
 * Exception thrown when a SAP remote function cannot be found.
 *
 * @package phpsap\exceptions
 * @author  Gregor J.
 * @license MIT
 */
class UnknownFunctionException extends SapException implements IUnknownFunctionException
{
}
