<?php

namespace phpsap\classes;

use phpsap\interfaces\IApiElement;
use JsonSerializable;
use InvalidArgumentException;

/**
 * Class phpsap\classes\ApiElement
 *
 * This class describes an API element.
 *
 * @package phpsap\classes
 * @author  Gregor J.
 * @license MIT
 */
class ApiElement implements IApiElement, JsonSerializable
{
    /**
     * @var array Storing the data of this element.
     */
    protected $element = [];

    /**
     * ApiElement constructor.
     * @param string $name
     * @param string $direction
     * @param string $dataType
     * @param bool   $optional
     * @throws \InvalidArgumentException
     */
    public function __construct($name, $direction, $dataType, $optional = true)
    {
        $this->setName($name);
        $this->setDirection($direction);
        $this->setDataType($dataType);
        $this->setOptional($optional);
    }

    /**
     * Returns the name of the API element.
     * @return string
     */
    public function getName()
    {
        return $this->element['name'];
    }

    /**
     * Set the name of the API element.
     * @param string $name
     * @throws \InvalidArgumentException
     */
    protected function setName($name)
    {
        if (!is_string($name) || empty(trim($name))) {
            throw new InvalidArgumentException('Expected API element name to be a string!');
        }
        $this->element['name'] = trim($name);
    }

    /**
     * Returns the API element direction defined by the TYPE_* constants of this
     * interface.
     * @return string
     */
    public function getDirection()
    {
        return $this->element['direction'];
    }

    /**
     * Set the direction of the API element.
     * @param string $direction
     * @throws \InvalidArgumentException
     */
    protected function setDirection($direction)
    {
        $validDirections = [
            static::DIR_TABLE,
            static::DIR_INPUT,
            static::DIR_OUTPUT,
            static::DIR_BOTH
        ];
        if (!in_array($direction, $validDirections, true)) {
            throw new InvalidArgumentException('Expected direction to be one of the DIR_* constants!');
        }
        $this->element['direction'] = $direction;
    }

    /**
     * Returns the data type for value of the API element defined by the PHP_TYPE_*
     * constants of this interface.
     * @return string
     */
    public function getDataType()
    {
        return $this->element['dataType'];
    }

    /**
     * Set the data type for the value of the API element. This can be bool, int,
     * float, string or DateTime.
     * @param string $dataType The data type for the value of the API element.
     * @throws \InvalidArgumentException
     */
    protected function setDataType($dataType)
    {
        $validDataTypes = ['bool', 'int', 'float', 'string', 'array'];
        if (!in_array($dataType, $validDataTypes, true)) {
            throw new InvalidArgumentException(
                'Expected data type to be on of bool, int, float, string or array!'
            );
        }
        $this->element['dataType'] = $dataType;
    }

    /**
     * Returns whether the API element is optional.
     * @return bool
     */
    public function isOptional()
    {
        return array_key_exists('optional', $this->element)
               && $this->element['optional'] === true;
    }

    /**
     * Set the optional flag.
     * @param bool $optional Is this element optional?
     * @throws \InvalidArgumentException
     */
    protected function setOptional($optional)
    {
        if (!is_bool($optional)) {
            throw new InvalidArgumentException('Expected optional flag to be boolean!');
        }
        if ($optional === true) {
            $this->element['optional'] = true;
        } elseif ($optional === false && array_key_exists('optional', $this->element)) {
            unset($this->element['optional']);
        }
    }

    /**
     * Returns the optional description of the API element. In case there is no
     * description, null is returned.
     * @return string|null
     */
    public function getDescription()
    {
        if (array_key_exists('description', $this->element)) {
            return $this->element['description'];
        }
        return null;
    }

    /**
     * Sets an optional description of this element.
     * @param string $description
     * @throws \InvalidArgumentException
     */
    public function setDescription($description)
    {
        if ($description === null) {
            $description = '';
        }
        if (!is_string($description)) {
            throw new InvalidArgumentException('Expected API element description to be a string!');
        }
        if ($description === '') {
            unset($this->element['description']);
        } else {
            $this->element['description'] = trim($description);
        }
    }

    /**
     * Returns the members of a structure. In case there are no members, an empty
     * array is returned.
     * @return array
     */
    public function getMembers()
    {
        if (array_key_exists('members', $this->element)) {
            return $this->element['members'];
        }
        return [];
    }

    /**
     * Add a member of a structure (either array or table).
     * @param \phpsap\classes\ApiElement $member
     */
    public function addMember(ApiElement $member)
    {
        if (!array_key_exists('members', $this->element)) {
            $this->element['members'] = [];
        }
        $this->element['members'][$member->getName()] = $member;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link  https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by json_encode,
     *               which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return $this->element;
    }

    /**
     * Decode a JSON encoded array of API elements.
     * @param string $jsonString
     * @return array
     * @throws \InvalidArgumentException
     */
    public static function jsonUnserializeArray($jsonString)
    {
        $elements = json_decode($jsonString, true);
        if (!is_array($elements)) {
            throw new InvalidArgumentException(
                'Given string is no JSON encoded API element.'
            );
        }
        $result = [];
        foreach ($elements as $element) {
            $result[] = static::fromArray($element);
        }
        return $result;
    }

    /**
     * Create an API element from an array.
     * @param array $data
     * @return \phpsap\classes\ApiElement
     * @throws \InvalidArgumentException
     */
    public static function fromArray($data)
    {
        if (is_array($data)
            && array_key_exists('name', $data)
            && array_key_exists('direction', $data)
            && array_key_exists('dataType', $data)
        ) {
            $element = new static(
                $data['name'],
                $data['type'],
                $data['dataType']
            );
            if (array_key_exists('optional', $data)) {
                $element->setOptional($data['optional']);
            }
            if (array_key_exists('description', $data)) {
                $element->setDescription($data['description']);
            }
            if (array_key_exists('members', $data)) {
                foreach ($data['members'] as $member) {
                    $element->addMember(static::fromArray($member));
                }
            }
            return $element;
        }
        throw new InvalidArgumentException(
            'Given data is no API element.'
        );
    }
}
