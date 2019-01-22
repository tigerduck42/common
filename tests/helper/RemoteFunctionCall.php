<?php
/**
 * File tests/helper/RemoteFunctionCall.php
 *
 * Helper class extending the abstract remote function class for testing.
 *
 * @package common
 * @author  Gregor J.
 * @license MIT
 */

namespace tests\phpsap\classes\helper;

use phpsap\classes\AbstractRemoteFunctionCall;
use phpsap\interfaces\IConfig;

/**
 * Class tests\phpsap\classes\helper\RemoteFunctionCall
 *
 * Helper class extending the abstract remote function class for testing.
 *
 * @package tests\phpsap\classes\helper
 * @author  Gregor J.
 * @license MIT
 */
class RemoteFunctionCall extends AbstractRemoteFunctionCall
{
    /**
     * @var string function name
     */
    public $returnName = 'cketfemo';

    /**
     * The SAP remote function name.
     * @return string
     */
    public function getName()
    {
        return $this->returnName;
    }

    /**
     * Create a connection instance using the given config.
     * @param \phpsap\interfaces\IConfig $config
     * @return \phpsap\interfaces\IConnection
     * @throws \phpsap\interfaces\exceptions\IIncompleteConfigException
     */
    protected function createConnectionInstance(IConfig $config)
    {
        return new Connection($config);
    }

    /**
     * Make protected function public for testing.
     * Get the function instance
     * @return \phpsap\classes\AbstractFunction
     * @throws \phpsap\interfaces\exceptions\IConnectionFailedException
     * @throws \phpsap\interfaces\exceptions\IUnknownFunctionException
     */
    public function getFunction()
    {
        return parent::getFunction();
    }
}
