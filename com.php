<?php

// Load core functions we need
foreach (glob('./core/func' . DIRECTORY_SEPARATOR . '*.php') as $core_func_file) {
    require_once $core_func_file;
}

// Load files we need
require_once './settings.php';
require_once './root.php';
require_once './autoload/src/Loader.php';

// Instance autoloader with project document root path
new \Aautoloder\Loader(array(PROJECT_DOCUMENT_ROOT));

// Use database
use System\DB\DBM;

// Set db as global for use and updates
$GLOBALS['DBM_PDO_INST'] = DBM::get_instance();