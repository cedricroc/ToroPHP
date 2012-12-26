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
 * Management callbacks
 * 
 * Hook authorized :
 * - 404
 * - before_request
 * - before_handler
 * - after_handler
 * - after_request
 */
class ToroPHP_Hook
{
    private static $_instance;
    private $_hooks = array();

    
    
    private function __construct() 
    {
        
    }
    
    
    private function __clone()
    {
        
    }
    
    
    /**
     * Add hook into process
     * @param string $hookName
     * @param function $fn
     */
    public static function add($hookName = '', $fn = null)
    {
        $instance = self::getInstance();
        $instance->_hooks[$hookName][] = $fn;
    }
    
    
    /**
     * Execute hook function
     * @param string $hookName
     * @param string $params
     */
    public static function fire($hookName, $params = null)
    {
        $instance = self::getInstance();
        if (isset($instance->_hooks[$hookName])) {
            foreach ($instance->_hooks[$hookName] as $fn) {
                call_user_func_array($fn, array(&$params));
            }
        }
    }
    
    
    /**
     * Return a ToroHook instance
     * @return ToroHook
     */
    public static function getInstance()
    {
        if (empty(self::$_instance)) {
            self::$_instance = new ToroPHP_Hook();
        }
        return self::$_instance;
    }
}