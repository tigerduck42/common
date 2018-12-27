<?php
/**
 * File src/AbstractConfig.php
 *
 * Basic configuration.
 *
 * @package common
 * @author  Gregor J.
 * @license MIT
 */

namespace phpsap\classes;

use phpsap\interfaces\IConfig;

/**
 * Class phpsap\classes\AbstractConfig
 *
 * Abstract class to configure basic connection parameters for SAP remote function
 * calls, that are common to both connection types (A, and B).
 *
 * @package phpsap\classes
 * @author  Gregor J.
 * @license MIT
 */
abstract class AbstractConfig implements \JsonSerializable, IConfig
{
    /**
     * @var array configuration data
     */
    protected $config;

    /**
     * Constructor optionally loads the configuration either from a JSON encoded
     * string or from an array.
     * @param array|string $config the configuration
     * @throws \InvalidArgumentException
     */
    public function __construct($config = null)
    {
        $this->config = [];
        if (is_array($config)) {
            $this->loadArray($config);
        } elseif (is_string($config)) {
            $this->loadJsonString($config);
        } elseif ($config !== null) {
            throw new \InvalidArgumentException(
                'Expected configuration to either be an array'
                . ', or a JSON encoded string!'
            );
        }
    }

    /**
     * Load configuration array.
     * @param array $config
     * @throws \InvalidArgumentException
     */
    protected function loadArray($config)
    {
        if (!is_array($config)) {
            throw new \InvalidArgumentException(
                'Expected config to be an array!'
            );
        }
        foreach ($config as $key => $value) {
            $key = strtolower($key);
            $method = sprintf('set%s', ucfirst($key));
            if (method_exists($this, $method)) {
                $this->{$method}($value);
            }
        }
    }

    /**
     * Load configuration from a JSON string.
     * @param string $config
     * @throws \InvalidArgumentException
     */
    protected function loadJsonString($config)
    {
        if (!is_string($config)) {
            throw new \InvalidArgumentException(
                'Expected config to be a JSON encoded string!'
            );
        }
        $configArr = json_decode($config, true);
        $this->loadArray($configArr);
    }

    /**
     * Specify data which should be serialized to JSON
     * @link  https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return $this->config;
    }

    /**
     * Get the username.
     * @return string the username
     */
    public function getUser()
    {
        return $this->config['user'];
    }

    /**
     * Set the username.
     * @param string $value the username
     */
    protected function setUser($value)
    {
        $this->config['user'] = (string)$value;
    }

    /**
     * Get the password.
     * @return string the password
     */
    public function getPasswd()
    {
        return $this->config['passwd'];
    }

    /**
     * Set the password.
     * @param string $value the password
     */
    protected function setPasswd($value)
    {
        $this->config['passwd'] = (string)$value;
    }

    /**
     * Get the Client to which to logon.
     * @return string the client
     */
    public function getClient()
    {
        return $this->config['client'];
    }

    /**
     * Set the Client to which to logon.
     * @param string $value the client
     */
    protected function setClient($value)
    {
        $this->config['client'] = (string)$value;
    }

    /**
     * Get the logon language.
     * @return string the logon language
     */
    public function getLang()
    {
        return $this->config['lang'];
    }

    /**
     * Set the logon language.
     * @param string $value the logon language
     * @throws \InvalidArgumentException
     */
    protected function setLang($value)
    {
        if (!preg_match('~^[A-Z]{2}$~', $value, $match)) {
            throw new \InvalidArgumentException(
                'Expected two letter country code as language.'
            );
        }
        $this->config['lang'] = (string)$match[0];
    }

    /**
     * If the connection needs to be made through a firewall using a SAPRouter.
     * @return string the saprouter
     */
    public function getSaprouter()
    {
        return $this->config['saprouter'];
    }

    /**
     * If the connection needs to be made through a firewall using a SAPRouter,
     * specify the SAPRouter parameters in the following format:
     * /H/hostname/S/portnumber/H/
     * @param string the saprouter
     */
    public function setSaprouter($value)
    {
        $this->config['saprouter'] = (string)$value;
    }

    /**
     * Get the trace level (0-3)
     * @return int the trace level
     */
    public function getTrace()
    {
        return $this->config['trace'];
    }

    /**
     * Set the trace level (0-3)
     * @param int the trace level
     * @throws \InvalidArgumentException
     */
    public function setTrace($value)
    {
        if (!preg_match('~^[0-3]$~', $value, $match)) {
            throw new \InvalidArgumentException(
                'The trace level can only be 0-3.'
            );
        }
        $this->config['trace'] = (int)$match[0];
    }

    /**
     * Only needed it if you want to connect to a non-Unicode backend using a
     * non-ISO-Latin-1 user name or password. The RFC library will then use that
     * codepage for the initial handshake, thus preserving the characters in
     * username/password.
     *
     * @return int the codepage
     */
    public function getCodepage()
    {
        return $this->config['codepage'];
    }

    /**
     * Only needed it if you want to connect to a non-Unicode backend using a
     * non-ISO-Latin-1 user name or password. The RFC library will then use that
     * codepage for the initial handshake, thus preserving the characters in
     * username/password.
     *
     * @param int the codepage
     */
    public function setCodepage($value)
    {
        $this->config['codepage'] = (int)$value;
    }

    /**
     * Get the destination in RfcOpenConnection.
     * @return string the destination
     */
    public function getDest()
    {
        return $this->config['dest'];
    }

    /**
     * Set the destination in RfcOpenConnection.
     * @param string the destination
     */
    public function setDest($value)
    {
        $this->config['dest'] = (string)$value;
    }

    /**
     * Generate the type of configuration needed by the PHP module in order to
     * establish a connection to SAP.
     * @return mixed
     */
    abstract public function generateConfig();
}
