<?php
/**
 * File tests/AbstractConfigStorageTest.php
 *
 * Test the abstract config storage class.
 *
 * @package common
 * @author  Gregor J.
 * @license MIT
 */

namespace tests\phpsap\classes;

use phpsap\classes\AbstractConfigStorage;
use phpsap\exceptions\ConfigKeyNotFoundException;
use Psr\Container\ContainerInterface;
use Serializable;
use tests\phpsap\classes\helper\ConfigStorage;

/**
 * Class AbstractConfigStorageTest
 *
 * Test the abstract config storage class.
 *
 * @package tests\phpsap\classes
 * @author  Gregor J.
 * @license MIT
 */
class AbstractConfigStorageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test config container class inheritance.
     */
    public function testInheritedClasses()
    {
        $config = new ConfigStorage();
        static::assertInstanceOf(Serializable::class, $config);
        static::assertInstanceOf(AbstractConfigStorage::class, $config);
        static::assertInstanceOf(ConfigStorage::class, $config);
    }

    /**
     * Data provider of valid constructor parameters.
     * @return array
     */
    public static function validConstructorParameters()
    {
        return [
            [null, '[]'],
            [[], '[]'],
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
        $config = new ConfigStorage($param);
        static::assertInstanceOf(ConfigStorage::class, $config);
        static::assertSame($expectedJson, $config->debugInternalConfig());
    }

    /**
     * Data provider of invalid constructor parameters.
     * @return array
     */
    public static function invalidConstructorParameters()
    {
        return [
            ['', 'Expected configuration to be an array!'],
            ['945', 'Expected configuration to be an array!'],
            ['APNyRGdV', 'Expected configuration to be an array!'],
            [545, 'Expected configuration to be an array!'],
            [58.5, 'Expected configuration to be an array!'],
            [new \stdClass(), 'Expected configuration to be an array!']
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
        new ConfigStorage($param);
    }

    /**
     * Test the internal set() get() and has() methods.
     */
    public function testContainerInterfaceFunctions()
    {
        $config = new ConfigStorage(['qvypepzo' => 'K77wHitp', 'sjkynhiv' => 'tGJQqHtg']);
        static::assertInstanceOf(ConfigStorage::class, $config);
        static::assertTrue($config->has('qvypepzo'));
        static::assertSame('K77wHitp', $config->get('qvypepzo'));
        static::assertFalse($config->has('sjkynhiv'));
        $this->setExpectedException(
            ConfigKeyNotFoundException::class,
            'No entry was found for configuration key \'sjkynhiv\'.'
        );
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
     * @expectedException \LogicException
     * @expectedExceptionMessage Expected configuration key to be a string value.
     */
    public function testSettingInvalidConfigurationKeys($key)
    {
        $config = new ConfigStorage();
        $config->set($key, 'skbevrvd');
    }

    /**
     * Test getting an invalid configuration key.
     * @param mixed $key
     * @dataProvider invalidConfigurationKeys
     * @expectedException \LogicException
     * @expectedExceptionMessage Expected configuration key to be a string value.
     */
    public function testGettingInvalidConfigurationKeys($key)
    {
        $config = new ConfigStorage();
        $config->get($key);
    }

    /**
     * Test having an invalid configuration key.
     * @param mixed $key
     * @dataProvider invalidConfigurationKeys
     * @expectedException \LogicException
     * @expectedExceptionMessage Expected configuration key to be a string value.
     */
    public function testHavingInvalidConfigurationKeys($key)
    {
        $config = new ConfigStorage();
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
        new ConfigStorage(['qvypepzo' => $value]);
    }

    /**
     * Test PHP object serialization.
     */
    public function testSerialization()
    {
        $config = new ConfigStorage(['qvypepzo' => 'd7sdKgbZ']);
        $expected = 'C:41:"tests\phpsap\classes\helper\ConfigStorage":36:{a:1:{s:8:"qvypepzo";s:8:"d7sdKgbZ";}}';
        $actual = serialize($config);
        static::assertSame($expected, $actual);
    }

    public function testUnserialization()
    {
        $serialized = serialize(new ConfigStorage(['qvypepzo' => 'd7sdKgbZ']));
        $config = unserialize($serialized);
        /**
         * @var \tests\phpsap\classes\helper\ConfigStorage $config
         */
        static::assertInstanceOf(Serializable::class, $config);
        static::assertInstanceOf(AbstractConfigStorage::class, $config);
        static::assertInstanceOf(ConfigStorage::class, $config);
        static::assertTrue($config->has('qvypepzo'));
        static::assertSame('d7sdKgbZ', $config->get('qvypepzo'));
        static::assertSame('d7sdKgbZ', $config->getQvypepzo());
    }
}
