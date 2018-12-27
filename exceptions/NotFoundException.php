<?php
/**
 * File exceptions/NotFoundException.php
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
 * Class phpsap\exceptions\NotFoundException
 *
 * No entry was found in the container.
 *
 * @package phpsap\exceptions
 * @author  Gregor J.
 * @license MIT
 */
class NotFoundException extends \RuntimeException implements NotFoundExceptionInterface
{

}
