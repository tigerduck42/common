<?php
/**
 * File src/AbstractRemoteFunctionCall.php
 *
 * PHP/SAP proxy class for SAP remote function calls.
 *
 * @package common
 * @author  Gregor J.
 * @license MIT
 */

namespace phpsap\classes;

use phpsap\interfaces\IConfig;
use phpsap\interfaces\IFunction;

/**
 * Class Tests\phpsap\saprfc\AbstractRemoteFunctionCall
 *
 * Abstract class handling a PHP/SAP connection and remote function.
 *
 * @package phpsap\classes
 * @author  Gregor J.
 * @license MIT
 */
abstract class AbstractRemoteFunctionCall implements IFunction
{
    /**
     * @var string The connection ID of the current SAP remote connection.
     */
    protected $connectionId;

    /**
     * @var \phpsap\classes\AbstractFunction
     */
    protected $function;

    /**
     * Initialize the function call, using the configuration.
     * @param \phpsap\interfaces\IConfig $config
     */
    public function __construct(IConfig $config)
    {
        //create a new instance of the connection without actually connecting
        $connection = $this->createConnectionInstance($config);
        //determine the connection ID of the connection
        $this->connectionId = $connection->getId();
        //add the connection to the pool in case it doesn't exist there yet
        if (!ConnectionPool::has($this->connectionId)) {
            ConnectionPool::add($this->connectionId, $connection);
        }
    }

    /**
     * Remove the function instance.
     * @return \phpsap\classes\AbstractRemoteFunctionCall $this
     */
    public function reset()
    {
        $this->function = null;
        return $this;
    }

    /**
     * Set function call parameter.
     * @param string                           $name
     * @param array|bool|float|int|string|null $value
     * @return \phpsap\classes\AbstractRemoteFunctionCall $this
     * @throws \phpsap\interfaces\IConnectionFailedException
     * @throws \phpsap\interfaces\IUnknownFunctionException
     */
    public function setParam($name, $value)
    {
        $this->getFunction()
            ->setParam($name, $value);
        return $this;
    }

    /**
     * Invoke SAP remote function call.
     * @param null|array $params Optional parameter array.
     * @return array result.
     * @throws \phpsap\interfaces\IConnectionFailedException
     * @throws \phpsap\interfaces\IUnknownFunctionException
     * @throws \phpsap\exceptions\FunctionCallException
     */
    public function invoke($params = null)
    {
        //invoke the remove function call
        $result = $this->getFunction()
            ->invoke($params);
        $this->reset();
        //cast the return values to the types defined in the implementing class
        $typecast = $this->getReturnTypecast();
        if ($typecast !== null) {
            return $typecast->cast($result);
        }
        return $result;
    }

    /**
     * Get the function instance.
     * @return \phpsap\classes\AbstractFunction
     * @throws \phpsap\interfaces\IConnectionFailedException
     * @throws \phpsap\interfaces\IUnknownFunctionException
     */
    protected function &getFunction()
    {
        if ($this->function === null) {
            //now connect and prepare the function
            $this->function = ConnectionPool::get($this->connectionId)
                ->prepareFunction($this->getName());
        }
        return $this->function;
    }

    /**
     * The SAP remote function name.
     * @return string
     */
    abstract public function getName();

    /**
     * Get the typecast of the expected return values.
     * @return \kbATeam\TypeCast\ITypeCast|null
     */
    abstract protected function getReturnTypecast();

    /**
     * Create a connection instance using the given config.
     * @param \phpsap\interfaces\IConfig $config
     * @return \phpsap\interfaces\IConnection
     */
    abstract protected function createConnectionInstance(IConfig $config);
}
