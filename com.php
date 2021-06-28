<?php

// Load core functions we need
foreach (glob('./core/func' . DIRECTORY_SEPARATOR . '*.php') as $core_func_file) {
    require_once $core_func_file;
}

// Load files
require_once './root.php';
require_once './settings.php';
require_once './autoload/src/Loader.php';

// Instance autoloader
new \Aautoloder\Loader(array(PROJECT_DOCUMENT_ROOT));

use System\DB\DBM;

// Set db as global for use and updates
$GLOBALS['DBM_PDO_INST'] = DBM::get_instance();