<?php

foreach (glob(dirname(__FILE__) . '/src/*') as $file) {
    
    require_once $file;
}