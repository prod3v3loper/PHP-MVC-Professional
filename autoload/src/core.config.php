<?php

// Set this to false so that you no longer see the debugging
define('MBT_DEBUG_DISPLAY_AUTOLOAD', false);
// Set this to false so that you no longer see the debugging
define('MBT_DEBUG_DISPLAY_AUTOLOAD_SEARCH', false);
// This activate/deactivate the indexing of the classes in file
define('MBT_CORE_AUTOLOAD_INDEX', true);
// Max read lines in file to find the class
define('MBT_CORE_AUTOLOAD_READ_MAX_LINES', 49);
// Files
define('MBT_CORE_AUTOLOAD_LOG_FOLDER', PROJECT_DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'autoload' . DIRECTORY_SEPARATOR . 'log');
define('MBT_CORE_AUTOLOAD_LOG_FILE', PROJECT_DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'autoload' . DIRECTORY_SEPARATOR . 'autoload.log');
define('MBT_CORE_AUTOLOAD_LOG_LOGS', PROJECT_DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'autoload/log/_' . date('Y_m_d', time()) . '.log');
