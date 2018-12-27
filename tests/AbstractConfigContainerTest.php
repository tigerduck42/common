<?php
/**
 * File tests/AbstractConfigContainerTest.php
 *
 * Test the abstract config container class.
 *
 * @package common
 * @author  Gregor J.
 * @license MIT
 */

namespace tests\phpsap\classes;

use phpsap\classes\AbstractConfigContainer;
use phpsap\exceptions\ConfigKeyNotFoundException;
use Psr\Container\ContainerInterface;
use tests\phpsap\classes\helper\ConfigContainer;

/**
 * Class tests\phpsap\classes\AbstractConfigContainerTest
 *
 * Test the abstract config container class.
 *
 * @package tests\phpsap\classes
 * @author  Gregor J.
 * @license MIT
 */
class AbstractConfigContainerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test config container class inheritance.
     */
    public function testInheritedClasses()
    {
        $config = new ConfigContainer();
        static::assertInstanceOf(ContainerInterface::class, $config);
        static::assertInstanceOf(AbstractConfigContainer::class, $config);
        static::assertInstanceOf(ConfigContainer::class, $config);
    }

    /**
     * Data provider of valid constructor parameters.
     * @return array
     */
    public static function validConstructorParameters()
    {
        return [
            [null, '[]'],
            ['{}', '[]'],
            ['[]', '[]'],
            [[], '[]'],
            ['["YkYpgeSz"]', '[]'],
            ['{"qvypepzo":"K77wHitp"}', '{"qvypepzo":"K77wHitp"}'],
            [['qvypepzo' => 'd7sdKgbZ'], '{"qvypepzo":"d7sdKgbZ"}'],
            [['qvypepzo' => 'fmVwxjSG', 'nJd1KqJE' => 890], '{"qvypepzo":"fmVwxjSG"}']
        ];
    }

    /**
     * Test creating a config instance using valid constructor parameters and
     * validate the result using json_encode on the config object.
     * @param null|array|string $param
     * @param string $expectedJson
     * @dataProvider validConstructorParameters
     */
    public function testValidConstructorParameters($param, $expectedJson)
    {
        $config = new ConfigContainer($param);
        static::assertInstanceOf(ConfigContainer::class, $config);
        static::assertSame($expectedJson, json_encode($config));
    }

    /**
     * Data provider of invalid constructor parameters.
     * @return array
     */
    public static function invalidConstructorParameters()
    {
        return [
            ['', 'Expected config to be a JSON encoded string!'],
            ['945', 'Expected config to be an array!'],
            ['APNyRGdV', 'Expected config to be a JSON encoded string!'],
            [545, 'Expected configuration to either be an array, or a JSON encoded string!'],
            [58.5, 'Expected configuration to either be an array, or a JSON encoded string!'],
            [new \stdClass(), 'Expected configuration to either be an array, or a JSON encoded string!'],
            ['{"IGbUKNhW": 784', 'Expected config to be a JSON encoded string!']
        ];
    }

    /**
     * Test exception thrown on invalid constructor parameter
     * @param mixed $param
     * @param string $message
     * @dataProvider invalidConstructorParameters
     */
    public function testInvalidConstructorParameters($param, $message)
    {
        $this->setExpectedException(\InvalidArgumentException::class, $message);
        new ConfigContainer($param);
    }

    /**
     * Data provider of invalid parameters for internal function loadJson().
     * @return array
     */
    public static function invalidParametersForInternalLoadJsonFunction()
    {
        return [
            [964],
            [4.4],
            [null],
            [''],
            ['{"bIsXiNGS": "qGRF2Mks"'],
            [new \stdClass()],
            [[]]
        ];
    }

    /**
     * Test internal function loadJson() using invalid parameters.
     * @param mixed $param
     * @dataProvider invalidParametersForInternalLoadJsonFunction
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected config to be a JSON encoded string!
     */
    public function testInvalidParametersForInternalLoadJsonFunction($param)
    {
        $config = new ConfigContainer();
        $config->loadJsonString($param);
    }

    /**
     * Test the PSR-11 container interface functions.
     */
    public function testContainerInterfaceFunctions()
    {
        $config = new ConfigContainer('{"qvypepzo":"K77wHitp", "sjkynhiv":"tGJQqHtg"}');
        static::assertInstanceOf(ConfigContainer::class, $config);
        static::assertTrue($config->has('qvypepzo'));
        static::assertSame('K77wHitp', $config->get('qvypepzo'));
        static::assertFalse($config->has('sjkynhiv'));
        $this->setExpectedException(ConfigKeyNotFoundException::class, 'No entry was found for configuration key \'sjkynhiv\'.');
        $config->get('sjkynhiv');
    }

    /**
     * Data provider for invalid configuration keys.
     * @return array
     */
    public static function invalidConfigurationKeys()
    {
        return [
            [150],
            [80.2],
            [null],
            [true],
            [false],
            [new \stdClass()],
            [[]],
            ['']
        ];
    }

    /**
     * Test setting an invalid configuration key.
     * @param mixed $key
     * @dataProvider invalidConfigurationKeys
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected configuration key to be a string value.
     */
    public function testSettingInvalidConfigurationKeys($key)
    {
        $config = new ConfigContainer();
        $config->set($key, 'skbevrvd');
    }

    /**
     * Test getting an invalid configuration key.
     * @param mixed $key
     * @dataProvider invalidConfigurationKeys
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected configuration key to be a string value.
     */
    public function testGettingInvalidConfigurationKeys($key)
    {
        $config = new ConfigContainer();
        $config->get($key);
    }

    /**
     * Test having an invalid configuration key.
     * @param mixed $key
     * @dataProvider invalidConfigurationKeys
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected configuration key to be a string value.
     */
    public function testHavingInvalidConfigurationKeys($key)
    {
        $config = new ConfigContainer();
        $config->has($key);
    }

    /**
     * Data provider of invalid configuration values.
     * @return array
     */
    public static function invalidConfigurationValues()
    {
        return [
            [[]],
            [null],
            [new \stdClass()]
        ];
    }

    /**
     * Test setting an invalid configuration value.
     * @param mixed $value
     * @dataProvider invalidConfigurationValues
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected configuration value to be either a string, floating point, integer or boolean value.
     */
    public function testSettingInvalidConfigurationValues($value)
    {
        new ConfigContainer(['qvypepzo' => $value]);
    }
}
