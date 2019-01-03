<?php
/**
 * File exceptions/SapException.php
 *
 * Generic SAP exception.
 *
 * @package common
 * @author  Gregor J.
 * @license MIT
 */

namespace phpsap\exceptions;

use phpsap\interfaces\exceptions\ISapException;

/**
 * Class phpsap\exceptions\SapException
 *
 * Generic SAP exception.
 *
 * @package phpsap\exceptions
 * @author  Gregor J.
 * @license MIT
 */
class SapException extends \RuntimeException implements ISapException
{
}
