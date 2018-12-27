<?php
/**
 * File src/AbstractFunction.php
 *
 * PHP/SAP abstract function class.
 *
 * @package common
 * @author  Gregor J.
 * @license MIT
 */

namespace phpsap\classes;

use phpsap\interfaces\IFunction;

/**
 * Class phpsap\classes\AbstractFunction
 *
 * Abstract class to manage a single PHP/SAP remote function instance.
 *
 * @package phpsap\classes
 * @author  Gregor J.
 * @license MIT
 */
abstract class AbstractFunction implements IFunction
{
    /**
     * @var mixed
     */
    protected $connection;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $params;

    /**
     * Initialize this class with a connection instance and the function name.
     * @param mixed $connection Referenced connection ressource.
     * @param string $name
     */
    public function __construct(&$connection, $name)
    {
        $this->connection = &$connection;
        $this->name = $name;
        $this->reset();
    }

    /**
     * Get the function name.
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Remove all parameters that have been set and start over.
     * @return \phpsap\classes\AbstractFunction $this
     */
    public function reset()
    {
        $this->params = [];
        return $this;
    }

    /**
     * Set function call parameter.
     * @param string                           $name
     * @param array|string|float|int|bool|null $value
     * @return \phpsap\classes\AbstractFunction $this
     * @throws \InvalidArgumentException
     */
    public function setParam($name, $value)
    {
        if (!is_string($name) || empty($name)) {
            throw new \InvalidArgumentException(sprintf(
                'Expected function %s invoke parameter name to be string',
                $this->getName()
            ));
        }
        $this->params[$name] = $value;
        return $this;
    }

    /**
     * Get a parameter previously defined using setParam()
     * @param string $name
     * @param null   $default
     * @return mixed|null
     */
    protected function getParam($name, $default = null)
    {
        if (array_key_exists($name, $this->params)) {
            return $this->params[$name];
        }
        return $default;
    }

    /**
     * Invoke the prepared function call.
     * @param null|array $params Optional parameter array.
     * @return array
     * @throws \InvalidArgumentException
     * @throws \phpsap\exceptions\ConnectionFailedException
     * @throws \phpsap\exceptions\FunctionCallException
     */
    public function invoke($params = null)
    {
        if ($params === null) {
            $params = [];
        }
        if (!is_array($params)) {
            throw new \InvalidArgumentException(sprintf(
                'Expected function %s invoke parameters to be array, but got %s.',
                $this->getName(),
                gettype($params)
            ));
        }
        foreach ($params as $name => $value) {
            $this->setParam($name, $value);
        }
        return $this->execute();
    }

    /**
     * Clear remote function call.
     */
    abstract public function __destruct();

    /**
     * Execute the prepared function call.
     * @return array
     * @throws \phpsap\exceptions\ConnectionFailedException
     * @throws \phpsap\exceptions\FunctionCallException
     */
    abstract protected function execute();
}
