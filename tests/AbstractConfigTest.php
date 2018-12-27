<?php
/**
 * File tests/AbstractConfigTest.php
 *
 * Test the abstract config class.
 *
 * @package common
 * @author  Gregor J.
 * @license MIT
 */

namespace tests\phpsap\classes;

use phpsap\classes\AbstractConfig;
use phpsap\interfaces\IConfig;
use tests\phpsap\classes\helper\Config;

/**
 * Class AbstractConfigTest
 *
 * Test the abstract config class.
 *
 * @package tests\phpsap\classes
 * @author  Gregor J.
 * @license MIT
 */
class AbstractConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test config class inheritance.
     */
    public function testInheritedClasses()
    {
        $config = new Config();
        static::assertInstanceOf(IConfig::class, $config);
        static::assertInstanceOf(AbstractConfig::class, $config);
        static::assertInstanceOf(Config::class, $config);
    }

    /**
     * Test all getter methods at once.
     */
    public function testGetters()
    {
        $config = new Config([
            'user' => 'iCwJNWMB',
            'passwd' => 'i1xst7mQ',
            'client' => '275',
            'lang' => 'AB',
            'saprouter' => 'jxpzygit.example.com',
            'trace' => '3',
            'codepage' => '912',
            'dest' => 'PqOuhKt8'
        ]);
        static::assertInstanceOf(Config::class, $config);
        static::assertSame('iCwJNWMB', $config->getUser());
        static::assertSame('i1xst7mQ', $config->getPasswd());
        static::assertSame('275', $config->getClient());
        static::assertSame('AB', $config->getLang());
        static::assertSame('jxpzygit.example.com', $config->getSaprouter());
        static::assertSame(3, $config->getTrace());
        static::assertSame(912, $config->getCodepage());
        static::assertSame('PqOuhKt8', $config->getDest());
    }

    /**
     * Data provider for invalid lang values.
     * @return array
     */
    public static function invalidLangValues()
    {
        return [
            [''],
            ['RNEITCKL'],
            ['hayhvcmr'],
            [705],
            [3.57],
            [null],
            ["\0"],
            [[]],
            [new \stdClass()]
        ];
    }

    /**
     * Test invalid values for config parameter lang.
     * @param mixed $lang
     * @dataProvider invalidLangValues
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected two letter country code as language.
     */
    public function testInvalidLangValues($lang)
    {
        new Config(['lang' => $lang]);
    }

    /**
     * Data provider of invalid trace values.
     * @return array
     */
    public static function invalidTraceValues()
    {
        return [
            [''],
            ['UIA7qtqa'],
            ['3l96HFZi'],
            [725],
            [-1],
            [3.46],
            [null],
            ["\0"],
            [[]],
            [new \stdClass()]
        ];
    }

    /**
     * Test invalid values for config parameter trace.
     * @param mixed $trace
     * @dataProvider invalidTraceValues
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The trace level can only be 0-3.
     */
    public function testInvalidTraceValues($trace)
    {
        new Config(['trace' => $trace]);
    }
}
