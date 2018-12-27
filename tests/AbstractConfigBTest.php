<?php
/**
 * File src/AbstractConfigBTest.php
 *
 * Test the abstract config type B class.
 *
 * @package common
 * @author  Gregor J.
 * @license MIT
 */

namespace tests\phpsap\classes;

use phpsap\classes\AbstractConfig;
use phpsap\classes\AbstractConfigB;
use phpsap\interfaces\IConfig;
use phpsap\interfaces\IConfigB;
use tests\phpsap\classes\helper\ConfigB;

/**
 * Class tests\phpsap\classes\AbstractConfigBTest
 *
 * Test the abstract config type B class.
 *
 * @package tests\phpsap\classes
 * @author  Gregor J.
 * @license MIT
 */
class AbstractConfigBTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test config class inheritance.
     */
    public function testInheritedClasses()
    {
        $config = new ConfigB();
        static::assertInstanceOf(IConfig::class, $config);
        static::assertInstanceOf(IConfigB::class, $config);
        static::assertInstanceOf(AbstractConfig::class, $config);
        static::assertInstanceOf(AbstractConfigB::class, $config);
        static::assertInstanceOf(ConfigB::class, $config);
    }

    /**
     * Test all getter methods at once.
     */
    public function testGetters()
    {
        $config = new ConfigB([
            'r3name' => 'Q9kqMflN',
            'mshost' => 'xdhboixv.example.com',
            'group' => 'AHeiEaYp'
        ]);
        static::assertInstanceOf(ConfigB::class, $config);
        static::assertSame('Q9kqMflN', $config->getR3name());
        static::assertSame('xdhboixv.example.com', $config->getMshost());
        static::assertSame('AHeiEaYp', $config->getGroup());
    }
}
