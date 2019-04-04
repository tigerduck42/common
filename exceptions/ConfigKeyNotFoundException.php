<?php
/**
 * File exceptions/ConfigKeyNotFoundException.php
 *
 * No entry was found in the configuration storage.
 *
 * @package common
 * @author  Gregor J.
 * @license MIT
 */

namespace phpsap\exceptions;

use phpsap\interfaces\exceptions\IConfigKeyNotFoundException;

/**
 * Class ConfigKeyNotFoundException
 *
 * No entry was found in the configuration storage.
 *
 * @package phpsap\exceptions
 * @author  Gregor J.
 * @license MIT
 */
class ConfigKeyNotFoundException extends SapException implements IConfigKeyNotFoundException
{
}
