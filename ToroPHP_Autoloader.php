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
 * ToroPHP_Autoloader main class.
 *
 * @author  Cédric ROCHART
 */
class ToroPHP_Autoloader
{

    /**
     * Handles autoloading of classes.
     *
     * @param   string  $class  class name
     *
     * @return  Boolean         true if the class has been loaded
     */
    static public function autoload($class)
    {
        if (0 !== strpos($class, 'ToroPHP')) {
            return;
        }

        if (file_exists($file = dirname(__FILE__) . '/' . str_replace('_', '/', $class) . '.php')) {
            require $file;
        }
    }
    
}
