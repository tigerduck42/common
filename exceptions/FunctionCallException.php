<?php
/**
 * File exceptions/FunctionCallException.php
 *
 * PHP/SAP function call failed.
 *
 * @package exceptions
 * @author  Gregor J.
 * @license MIT
 */

namespace phpsap\exceptions;

use phpsap\interfaces\exceptions\IFunctionCallException;

/**
 * Class FunctionCallException
 *
 * Exception thrown when a PHP/SAP function call failed.
 *
 * @package phpsap\exceptions
 * @author  Gregor J.
 * @license MIT
 */
class FunctionCallException extends SapException implements IFunctionCallException
{
}
