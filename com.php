<?php

define('DEBUG', true); // Activate debug

if (DEBUG) {
    // Overwrite ini settings debug
    ini_set('html_errors', 1);
    ini_set('error_reporting', -1); // E_ALL
    ini_set('display_errors', 1); // On
    error_reporting(-1); // Report all
}

session_start();

$locallist = array(
    'localhost',
    '127.0.0.1',
    'localhost:8000',
    '127.0.0.1:8000'
);

$GLOBALS['PATH'] = '';
if (in_array($_SERVER['HTTP_HOST'], $locallist)) {
    $GLOBALS['PATH'] = DIRECTORY_SEPARATOR;
}

// Load core functions we need
foreach (glob('./core/func' . DIRECTORY_SEPARATOR . '*.php') as $core_func_file) {
    require_once $core_func_file;
}

// Load files we need
require_once './root.php';
require_once './autoload/src/Loader.php';

// Instance autoloader with project document root path
new Aautoloder\Loader(array(PROJECT_DOCUMENT_ROOT));

(new core\classes\dotenv\Dotenv(PROJECT_DOCUMENT_ROOT . '/.env'))->load();

require_once './settings.php';

// Set db as global for use and updates
$GLOBALS['DBM_PDO_INST'] = core\classes\db\DBM::getInstance();

// After db for db inserts
new core\classes\error\ErrorPHP();
