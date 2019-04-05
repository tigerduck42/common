<?php

namespace tests\phpsap\classes;

use InvalidArgumentException;
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
        static::assertSame('IN_INT', $element->getName());
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
     * Test setting and removing the description.
     */
    public function testDescription()
    {
        $element = new ApiElement('IN_INT', ApiElement::DIR_INPUT, 'int');
        static::assertNull($element->getDescription());
        $element->setDescription('Hello World!');
        static::assertSame('Hello World!', $element->getDescription());
        $element->setDescription('');
        static::assertNull($element->getDescription());
        $element->setDescription('Hello PHP!');
        static::assertSame('Hello PHP!', $element->getDescription());
        $element->setDescription(null);
        static::assertNull($element->getDescription());
    }

    /**
     * Test adding members to an element.
     */
    public function testAddingMembers()
    {
        $element = new ApiElement('IN_ADDRESS', ApiElement::DIR_INPUT, 'array');
        $element->addMember(new ApiElement('ADDRESS', ApiElement::DIR_INPUT, 'string'));
        $element->addMember(new ApiElement('CODE', ApiElement::DIR_INPUT, 'string'));
        $element->addMember(new ApiElement('AREA', ApiElement::DIR_INPUT, 'string'));
        $element->addMember(new ApiElement('COUNTRY', ApiElement::DIR_INPUT, 'string'));
        $members = $element->getMembers();
        static::assertInternalType('array', $members);
        $elementNames = ['ADDRESS', 'CODE', 'AREA', 'COUNTRY'];
        foreach ($members as $member) {
            /**
             * @var \phpsap\classes\ApiElement $member
             */
            static::assertContains($member->getName(), $elementNames);
            static::assertSame(ApiElement::DIR_INPUT, $member->getDirection());
            static::assertSame('string', $member->getDataType());
            static::assertTrue($member->isOptional());
            static::assertNull($member->getDescription());
            static::assertEmpty($member->getMembers());
        }
    }

    /**
     * Test encoding API elements
     */
    public function testJsonEncode()
    {
        $elements = [];
        $element = new ApiElement('IN_ADDRESS', ApiElement::DIR_INPUT, 'array', true);
        $element->addMember(new ApiElement('ADDRESS', ApiElement::DIR_INPUT, 'string'));
        $element->addMember(new ApiElement('CODE', ApiElement::DIR_INPUT, 'string'));
        $element->addMember(new ApiElement('AREA', ApiElement::DIR_INPUT, 'string'));
        $element->addMember(new ApiElement('COUNTRY', ApiElement::DIR_INPUT, 'string'));
        $elements[] = $element;
        $jsonString = json_encode($elements);
        $expectedJsonString = '[{"name":"IN_ADDRESS",'
                              .'"direction":"input",'
                              .'"dataType":"array",'
                              .'"optional":true,'
                              .'"members":['
                              .'{"name":"ADDRESS",'
                              .'"direction":"input",'
                              .'"dataType":"string",'
                              .'"optional":true},'
                              .'{"name":"CODE",'
                              .'"direction":"input",'
                              .'"dataType":"string",'
                              .'"optional":true},'
                              .'{"name":"AREA",'
                              .'"direction":"input",'
                              .'"dataType":"string",'
                              .'"optional":true},'
                              .'{"name":"COUNTRY",'
                              .'"direction":"input",'
                              .'"dataType":"string",'
                              .'"optional":true}'
                              .']}]';
        static::assertJsonStringEqualsJsonString($expectedJsonString, $jsonString);
    }

    /**
     * Test decoding an array of elements.
     */
    public function testJsonDecode()
    {
        $elementsJsonEncoded = '[{"name":"IN_ADDRESS",'
                              .'"direction":"input",'
                              .'"dataType":"array",'
                              .'"optional":true,'
                              .'"members":['
                              .'{"name":"ADDRESS",'
                              .'"direction":"input",'
                              .'"dataType":"string",'
                              .'"optional":true,'
                               .'"description": "Street, house number, door number, stairs, etc."},'
                              .'{"name":"CODE",'
                              .'"direction":"input",'
                              .'"dataType":"string",'
                              .'"optional":true},'
                              .'{"name":"AREA",'
                              .'"direction":"input",'
                              .'"dataType":"string",'
                              .'"optional":true},'
                              .'{"name":"COUNTRY",'
                              .'"direction":"input",'
                              .'"dataType":"string",'
                              .'"optional":true}'
                              .']}]';
        $elements = ApiElement::jsonUnserializeArray($elementsJsonEncoded);
        static::assertInternalType('array', $elements);
        static::assertCount(1, $elements);
        foreach ($elements as $element) {
            /**
             * @var \phpsap\classes\ApiElement $element
             */
            static::assertSame('IN_ADDRESS', $element->getName());
            static::assertSame(ApiElement::DIR_INPUT, $element->getDirection());
            static::assertSame('array', $element->getDataType());
            $members = $element->getMembers();
            static::assertInternalType('array', $members);
            $elementNames = ['ADDRESS', 'CODE', 'AREA', 'COUNTRY'];
            foreach ($members as $member) {
                /**
                 * @var \phpsap\classes\ApiElement $member
                 */
                static::assertContains($member->getName(), $elementNames);
                static::assertSame(ApiElement::DIR_INPUT, $member->getDirection());
                static::assertSame('string', $member->getDataType());
                static::assertTrue($member->isOptional());
                if ($member->getName() === 'ADDRESS') {
                    static::assertSame(
                        'Street, house number, door number, stairs, etc.',
                        $member->getDescription()
                    );
                } else {
                    static::assertNull($member->getDescription());
                }
                static::assertEmpty($member->getMembers());
            }
        }
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
            ['object'],
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

    /**
     * Data provider of invalid descriptions.
     * @return array
     */
    public static function invalidDescriptions()
    {
        return [
            [12345],
            [123.45],
            [true],
            [false],
            [new \stdClass()],
            [['Hello World!']]
        ];
    }

    /**
     * Test invalid description.
     * @param mixed $description
     * @dataProvider invalidDescriptions
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected API element description to be a string!
     */
    public function testInvalidDescription($description)
    {
        $element = new ApiElement('IN_INT', ApiElement::DIR_INPUT, 'int');
        $element->setDescription($description);
    }

    /**
     * Data provider of all non-array data types.
     * @return array
     */
    public static function nonArrayDataTypes()
    {
        return [
            ['bool'],
            ['int'],
            ['float'],
            ['string']
        ];
    }

    /**
     * Test adding members to non-array data types
     * @param string $dataType
     * @dataProvider nonArrayDataTypes
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Only tables and array data types can have members!
     */
    public function testAddingMembersToNonArrayDataTypes($dataType)
    {
        $element = new ApiElement('IN_ADDRESS', ApiElement::DIR_INPUT, $dataType);
        $element->addMember(new ApiElement('ADDRESS', ApiElement::DIR_INPUT, 'string'));
    }

    /**
     * Data provider of invalid JSON encoded API elements.
     * @return array
     */
    public static function invalidJsonEncodedApiElements()
    {
        return [
            [
                json_encode(new ApiElement('IN_INT', ApiElement::DIR_INPUT, 'int')),
                'Given data is no API element.'
            ],
            [
                [json_encode(new ApiElement('IN_INT', ApiElement::DIR_INPUT, 'int'))],
                'Expected JSON to be a string.'
            ],
            [
                '',
                'Given string is no JSON encoded list of API elements.'
            ],
            [
                ' ',
                'Given string is no JSON encoded list of API elements.'
            ],
            [
                'Hello World!',
                'Given string is no JSON encoded list of API elements.'
            ],
            [
                null,
                'Expected JSON to be a string.'
            ],
            [
                true,
                'Expected JSON to be a string.'
            ],
            [
                false,
                'Expected JSON to be a string.'
            ],
            [
                new stdClass(),
                'Expected JSON to be a string.'
            ],
            [
                12345,
                'Expected JSON to be a string.'
            ],
            [
                123.45,
                'Expected JSON to be a string.'
            ]
        ];
    }

    /**
     * Test invalid JSON encoded API elements.
     * @param string $json
     * @param string $message
     * @dataProvider invalidJsonEncodedApiElements
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Given string is no JSON encoded list of API elements.
     */
    public function testInvalidJsonEncodedApiElement($json, $message)
    {
        $this->setExpectedException(
            InvalidArgumentException::class,
            $message
        );
        ApiElement::jsonUnserializeArray($json);
    }
}
