<?php

namespace tests\phpsap\classes;

use phpsap\classes\ApiElement;
use phpsap\interfaces\IApiElement;
use JsonSerializable;

/**
 * Class tests\phpsap\classes\ApiElementTest
 *
 * Test the ApiElement class.
 *
 * @package tests\phpsap\classes
 * @author  Gregor J.
 * @license MIT
 */
class ApiElementTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test for the required interfaces.
     */
    public function testInheritance()
    {
        $element = new ApiElement('IN_INT', ApiElement::DIR_INPUT, 'int');
        static::assertInstanceOf(IApiElement::class, $element);
        static::assertInstanceOf(JsonSerializable::class, $element);
    }

    /**
     * Test the mandatory settings of the class.
     */
    public function testMandatorySettings()
    {
        $element = new ApiElement('IN_INT', ApiElement::DIR_INPUT, 'int');
        static::assertSame('IN_IN', $element->getName());
        static::assertSame(ApiElement::DIR_INPUT, $element->getDirection());
        static::assertSame('int', $element->getDataType());
    }

    /**
     * Data provider of valid optional flags.
     * @return array
     */
    public static function optionalFlag()
    {
        return [
            [true],
            [false]
        ];
    }

    /**
     * Test the optional flag of the class.
     * @param bool $optional
     * @dataProvider optionalFlag
     */
    public function testOptionalFlag($optional)
    {
        $element = new ApiElement('IN_INT', ApiElement::DIR_INPUT, 'int', $optional);
        static::assertSame($optional, $element->isOptional());
    }

    /**
     * Data provider of invalid element names.
     * @return array
     */
    public static function invalidNames()
    {
        return [
            [''],
            [' '],
            [null],
            [true],
            [false],
            [new \stdClass()],
            [['IN_INT']],
            [12345],
            [123.45]
        ];
    }

    /**
     * Test for invalid element names.
     * @param mixed $name
     * @dataProvider invalidNames
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected API element name to be a string!
     */
    public function testInvalidName($name)
    {
        new ApiElement($name, 'xxx', 'xxx');
    }

    /**
     * Data provider of invalid element directions
     * @return array
     */
    public static function invalidDirections()
    {
        return [
            [''],
            [' '],
            ['INPUT'],
            [' input'],
            ['input '],
            [null],
            [true],
            [false],
            [new \stdClass()],
            [['input']],
            [12345],
            [123.45]
        ];
    }

    /**
     * Test for invalid element directions.
     * @param mixed $direction
     * @dataProvider invalidDirections
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected direction to be one of the DIR_* constants!
     */
    public function testInvalidDirections($direction)
    {
        new ApiElement('IN_INT', $direction, 'xxx');
    }

    /**
     * Data provider of invalid PHP data types.
     */
    public static function invalidDataTypes()
    {
        return [
            [''],
            [' bool'],
            ['bool '],
            ['object']
            [null],
            [true],
            [false],
            [new \stdClass()],
            [['bool']],
            [12345],
            [123.45]
        ];
    }

    /**
     * Test for invalid data types.
     * @param mixed $dataType
     * @dataProvider invalidDataTypes
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected data type to be on of bool, int, float, string or array!
     */
    public function testInvalidDataType($dataType)
    {
        new ApiElement('IN_INT', ApiElement::DIR_INPUT, $dataType);
    }

    /**
     * Data provider of invalid optional flags.
     * @return array
     */
    public static function invalidOptionalFlags()
    {
        return [
            ['Hello World!'],
            ['true'],
            ['1'],
            [''],
            [1],
            [0],
            [null],
            [new \stdClass()],
            [12345],
            [123.45]
        ];
    }

    /**
     * Test for invalid optional flags.
     * @param mixed $optional
     * @dataProvider invalidOptionalFlags
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected optional flag to be boolean!
     */
    public function testInvalidOptionalFlag($optional)
    {
        new ApiElement('IN_INT', ApiElement::DIR_INPUT, 'int', $optional);
    }
}
