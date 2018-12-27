<?php
/**
 * File exceptions/ConfigKeyNotFoundExceptionException.php
 *
 * No entry was found in the container.
 *
 * @package common
 * @author  Gregor J.
 * @license MIT
 */

namespace phpsap\exceptions;

use Psr\Container\NotFoundExceptionInterface;

/**
 * Class phpsap\exceptions\ConfigKeyNotFoundException
 *
 * No entry was found in the container.
 *
 * @package phpsap\exceptions
 * @author  Gregor J.
 * @license MIT
 */
class ConfigKeyNotFoundException extends SapException implements NotFoundExceptionInterface
{
}
