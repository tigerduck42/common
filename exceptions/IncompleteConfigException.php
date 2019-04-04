<?php
/**
 * File exceptions/IncompleteConfigException.php
 *
 * PHP/SAP config incomplete.
 *
 * @package exceptions
 * @author  Gregor J.
 * @license MIT
 */

namespace phpsap\exceptions;

use phpsap\interfaces\exceptions\IIncompleteConfigException;

/**
 * Class IncompleteConfigException
 *
 * Exception thrown when the PHP/SAP config is incomplete.
 *
 * @package phpsap\exceptions
 * @author  Gregor J.
 * @license MIT
 */
class IncompleteConfigException extends SapException implements IIncompleteConfigException
{
}
