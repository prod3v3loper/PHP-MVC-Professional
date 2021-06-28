<?php

/**
 * This is the main index.
 * This file no longer needs to be modified. 
 * Everything is regulated via controllers and templates.
 */

// Get common file
require_once 'com.php';

// Use frontcontroller
use Controller\FrontController as FC;

// Instance frontcontroller with our document root path
$fc = new FC(DOCUMENT_ROOT);

// And run
$fc->run();