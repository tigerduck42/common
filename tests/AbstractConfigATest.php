<?php
/**
 * File tests/AbstractConfigATest.php
 *
 * Test the abstract config type A class.
 *
 * @package common
 * @author  Gregor J.
 * @license MIT
 */

namespace tests\phpsap\classes;

use phpsap\classes\AbstractConfig;
use phpsap\classes\AbstractConfigA;
use phpsap\interfaces\IConfig;
use phpsap\interfaces\IConfigA;
use tests\phpsap\classes\helper\ConfigA;

/**
 * Class tests\phpsap\classes\AbstractConfigATest
 *
 * Test the abstract config type A class.
 *
 * @package tests\phpsap\classes
 * @author  Gregor J.
 * @license MIT
 */
class AbstractConfigATest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test config class inheritance.
     */
    public function testInheritedClasses()
    {
        $config = new ConfigA();
        static::assertInstanceOf(IConfig::class, $config);
        static::assertInstanceOf(IConfigA::class, $config);
        static::assertInstanceOf(AbstractConfig::class, $config);
        static::assertInstanceOf(AbstractConfigA::class, $config);
        static::assertInstanceOf(ConfigA::class, $config);
    }

    /**
     * Test all getter methods at once.
     */
    public function testGetters()
    {
        $config = new ConfigA([
            'ashost' => 'wjkjelhr.example.com',
            'sysnr' => '307',
            'gwhost' => 'vtcihwur.example.com',
            'gwserv' => 'ozpqjyjt'
        ]);
        static::assertInstanceOf(ConfigA::class, $config);
        static::assertSame('wjkjelhr.example.com', $config->getAshost());
        static::assertSame('307', $config->getSysnr());
        static::assertSame('vtcihwur.example.com', $config->getGwhost());
        static::assertSame('ozpqjyjt', $config->getGwserv());
    }
}
