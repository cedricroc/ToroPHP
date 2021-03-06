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
 * 
 * @author Berker Peksag, Martin Bean, Robbie Coleman, and John Kurkowski for bug fixes and patches
 * @author Danillo César de O. Melo for ToroHook
 * @author Jason Mooberry for code optimizations and feedback
 * @author Kunal Anand
 * @author Cédric ROCHART <cedric.rochart@gmail.com>
 */


/**
 * ToroPHP_Request main class.
 *
 * @author  Cédric ROCHART
 */
class ToroPHP_Request
{
    
    private $_datas      = array();
    private $_server     = array();
    
    
    /**
     * Instantiate the request wrapper.
     *
     * @param array $server Value to inject or override in $_SERVER
     */
    public function __construct($server = array())
    {
        $this->_datas['get']       = $this->_cleanValue($_GET);
        $this->_datas['post']      = $this->_cleanValue($_POST);
        $this->_datas['cookie']    = $this->_cleanValue($_COOKIE);
        
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
	 * @param string $method  Possible value "get" (default), "post", "cookie"
	 * @return array or null if $method doesn't exist
	 */
    public function getDatas($method = 'get')
    {
        return isset($this->_datas[$method]) ? $this->_datas[$method] : null;
    }
    
    
    /**
	 * Add or init datas request
	 * 
	 * @param   string   $method   Possible value "get" (default), "post", "cookie"
	 * @param   array    $datas    $datas is merged with $_datas
	 */
    public function setDatas($method = 'get', $datas = array())
    {
        $this->_datas[$method] = array_merge($this->_datas[$method], $this->_cleanValue($datas));
    }
    
    
    /**
	 * Return an value by key
	 * example : $_GET['foo'] => $this->getValue('get', 'foo');
	 *
	 * @param   string   $method   Possible value "get" (default), "post", "cookie"
	 * @param string $key 
	 * @return mixed or null if $method doesn't exist
	 */
    public function getValue($method = 'get', $key = '')
    {
        return isset($this->_datas[$method]) && array_key_exists($key, $this->_datas[$method]) ? $this->_datas[$method][$key] : null;
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