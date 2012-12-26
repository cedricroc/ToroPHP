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
 * ToroPHP_Toro class route request
 * 
 * @author Cédric ROCHART <cedric.rochart@gmail.com>
 */
class ToroPHP_Toro
{
    
    private $_routes                = array();
    private $_request               = null;
    private $_validObject           = false;
    
    private $_method         = '';
    private $_pathInfo              = '/';
    private $_discoveredHandler     = null;
    private $_regexMatches          = array();
    private $_handlerInstance       = null;
    
    
    /**
     * Init router with all routes of application and object ToroPHP_Request
     * if object is correctly initialized $validObject containts true
     * false otherwise.
     * 
     * @param array $routes 
     * @param ToroPHP_Request $request
     */
    public function __construct($routes = array(), ToroPHP_Request $request = null)
    {
        if (    is_array($routes) && 
                !empty($routes) && 
                !is_null($request) && 
                $request instanceof ToroPHP_Request) {
            
            $this->_routes        = $routes;
            $this->_request       = $request;
            
            $this->_method = $this->_request->getServerValue('REQUEST_METHOD');
            
            $pi    = $this->_request->getServerValue('PATH_INFO');
            $opi   = $this->_request->getServerValue('ORIG_PATH_INFO');
            
            if (!empty($pi)) {
                
                $this->_pathInfo = $pi;
            } elseif (!empty($opi)) {
                
                $this->_pathInfo = $opi;
            }
            
            $this->_validObject = true;
        }
    }
    
    /**
     * Call correct controller for request if exist, serve 404 page otherwise
     */
    public function serve()
    {
        ToroPHP_Hook::fire('before_request');
        
        if ($this->_routeExiste() === true && $this->_callable() === true) {
            
            ToroPHP_Hook::fire('before_handler');
            
            $this->_addJSONHeader();
            
            if (!empty($this->_regexMatches)) {
                
                $parameters = array();
                $counter = 1;
                while ($parameter = array_shift($this->_regexMatches)) {
                    
                    $parameters['urlParameter_' . $counter] = $parameter[0];
                    $counter++;
                }
                $this->_request->setDatas('get', $parameters);
            }
            call_user_func(array($this->_handlerInstance, $this->_method), $this->_request);
            
            ToroPHP_Hook::fire('after_handler');
            
            ToroPHP_Hook::fire('after_request');
        } else {
            
            $this->serve404();
        }
    }
    
    /**
     * Return true if route exists, false otherwise.
     * 
     * @return boolean
     */
    private function _routeExiste()
    {
        if ($this->_validObject === true) {
            
            if (isset($this->_routes[$this->_pathInfo])) {
                
                $this->_discoveredHandler = $this->_routes[$this->_pathInfo];
                return true;
            } elseif ($this->_routes) {
            
                $tokens = array(
                        ':string' => '([a-zA-Z]+)',
                        ':number' => '([0-9]+)',
                        ':alpha'  => '([a-zA-Z0-9-_]+)'
                );
                 
                foreach ($this->_routes as $pattern => $handlerName) {
            
                    $pattern = strtr($pattern, $tokens);
                    
                    if (preg_match_all('#^/?' . $pattern . '/?$#', $this->_pathInfo, $matches)) {
                        
                        $this->_discoveredHandler = $handlerName;
                        $this->_regexMatches      = $matches;
                        return true;
                    }
                }
            }
        }
        
        return false;
    }
    
    /**
     * Return true if controller is callable, false otherwise.
     * 
     * @return boolean
     */
    private function _callable()
    {
        if ($this->_validObject === true) {
            
            if ($this->_discoveredHandler && 
                class_exists($this->_discoveredHandler)) {
                
                unset($this->_regexMatches[0]);
                $this->_handlerInstance = new $this->_discoveredHandler();
                
                if ($this->_request->isAjaxRequest() && 
                    method_exists($this->_discoveredHandler, $this->_method . '_xhr')) {
                    
                    $this->_method .= '_xhr';
                }
                
                if (method_exists($this->_handlerInstance, $this->_method)) {

                    return true;
                }
            }
        }
        
        return false;
    }
    
    /**
     * Add json header of request, this function called if is an ajax request.
     * 
     * @param string $request_method
     */
    private function _addJSONHeader()
    {
        if ($this->_request->isAjaxRequest() && 
            method_exists($this->_discoveredHandler, $this->_method)) {
             
            header('Content-type: application/json');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Cache-Control: no-store, no-cache, must-revalidate');
            header('Cache-Control: post-check=0, pre-check=0', false);
            header('Pragma: no-cache');
        }
    }
    
    /**
     * Return true if object is correctly initialized, false otherwise.
     * @return boolean
     */
    public function initState()
    {
        return $this->_validObject;
    }
    
    /**
     * Return 404 response
     * if 404 controller exists, call it, send header HTTP 404 otherwise.
     */
    public function serve404()
    {
        ToroPHP_Hook::fire('404');
        
        $this->_pathInfo = 404;
        if ($this->_routeExiste() === true && $this->_callable() === true) {
            
            $this->serve();
        } else {
            
            header(sprintf('HTTP/%s %s %s', 'GET', 404, 'Not found'));
            header("Status: 404 Not Found");
        }
    }
}