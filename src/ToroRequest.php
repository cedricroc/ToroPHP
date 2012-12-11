<?php
/**
 * ToroPHP (https://github.com/cedricroc/ToroPHP)
 * 
 * Original project https://github.com/anandkunal/ToroPHP
 * 
 * ToroPHP is a small router framework.
 *
 * @link      https://github.com/cedricroc/ToroPHP
 * @license   MIT
 * @author Cédric ROCHART <cedric.rochart@gmail.com>
 */

/**
 * ToroRequest main class.
 *
 * @author  Cédric ROCHART
 */
class ToroRequest
{
    
    private $_datas      = array();
    private $_server     = array();
    
    
    /**
     * Instantiate the request wrapper.
     *
     * @param string $method Name of superglobal (ex : post, get, ...)
     * @param array $server Value to inject or override in $_SERVER
     */
    public function __construct($method = 'get', $server = array())
    {
        $sMethod = '_' . ltrim(strtoupper($method), '_');
        
        if ($sMethod != '' && isset($GLOBALS[$sMethod])) {
            
            $this->_datas = $this->_cleanValue($GLOBALS[$sMethod]);
        }
        
        // Inject server value if exist
        $this->_server = array_merge($_SERVER, $server);
    }

    
    /**
     * Cleaning data of request by applying the following functions:
     * - trim
     * - urldecode
     * - htmlentities
     *
     * @param  array  &$values Datas request
     */
    private function _cleanValue($values = array())
    {
        foreach ($values as $key => $value) {

            if (is_array($value)) {

                $this->_cleanValue($value);
            } else {
                
                $values[$key] = htmlentities(urldecode(trim($value)));
            }
        }

        return $values;
    }
    
    
    /**
	 * Return clean datas
	 *
	 * @return array
	 */
    public function getDatas()
    {
        return $this->_datas;
    }
    
    
    /**
	 * Add or init datas request
	 */
    public function setDatas($datas)
    {
        $this->_datas = array_merge($this->_datas, $this->_cleanValue($datas));
    }
    
    
    /**
	 * Return an value by key
	 *
	 * @param string $key 
	 * @return mixed
	 */
    public function getValue($key = '')
    {
        if(array_key_exists($key, $this->_datas)) return $this->_datas[$key];

        return '';
    }
    
    
    /**
	 * Return true if is a ajax request
	 * 
	 * @return boolean
	 */
    public function isAjaxRequest()
    {
        return _isset($this->getServerValue('HTTP_X_REQUESTED_WITH')) 
        && $this->getServerValue('HTTP_X_REQUESTED_WITH') === 'xmlhttprequest';
    }

    
    
    /**
     * Return value for $parameter entry in $this->server
     * 
     * @param string $parameter
     * @return string|NULL
     */
    public function getServerValue($parameter = '')
    {
        $parameter = strtoupper($parameter);
        
        if (!empty($parameter) 
                && array_key_exists($parameter, $this->_server)) {
            
            return strtolower($this->_server[$parameter]); 
        }
        
        return null; 
    }
}