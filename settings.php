<?php

/**
 * Website
 */
define('WEBSITE_NAME', 'MVC by prod3v3loper'); // Name

/**
 * Debug setting
 */
define('DEBUG_DISPLAY', true); // Screen errors on website
define('DEBUG_LOG', true); // Log errors in file
define('DEBUG_LOG_FOLDER', PROJECT_DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'debug');
define('DEBUG_LOG_FILE', PROJECT_DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'debug/debug.log');
define('DEBUG_DB_LOG', false); // Log errors in database
define('DEBUG_MAIL_LOG', true); // Send errors per mail
define('DEBUG_ADMIN_MAIL', ''); // Send errors to this email

/**
 * Database setting
 */
define('DB_PREFIX', getenv('DB_PREFIX'));
define('DB_HOST', getenv('DB_HOST'));
define('DB_PORT', getenv('DB_PORT'));
define('DB_NAME', getenv('DB_NAME'));
define('DB_DSN', 'mysql:host=' . DB_HOST . ':' . DB_PORT . ';dbname=' . DB_NAME);
define('DB_USER', getenv('DB_USER'));
define('DB_PASS', getenv('DB_PASS'));

/**
 * SMTP Mail setting
 */
define('MAIL_HOST', getenv('MAIL_HOST'));
define('MAIL_USERNAME', getenv('MAIL_USERNAME'));
define('MAIL_PASSWORD', getenv('MAIL_PASSWORD'));
define('MAIL_PORT', getenv('MAIL_PORT'));
define('MAIL_SECURE', getenv('MAIL_SECURE'));
define('MAIL_FROM', getenv('MAIL_FROM'));
define('MAIL_FROM_NAME', getenv('MAIL_FROM_NAME'));
define('MAIL_ADMIN', getenv('MAIL_ADMIN'));
define('MAIL_ADMIN_NAME', getenv('MAIL_ADMIN_NAME'));

/**
 * Honeypot
 */
define('HONEYPOT_LOG_FILE', PROJECT_DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'debug/honeypot.log');

/**
 *
 * @global array $GLOBALS['error-default']
 * @name $error-default  Default array
 */
$GLOBALS['error-default'] = array(
    E_ERROR,
    E_WARNING,
    E_PARSE,
    E_NOTICE,
    E_DEPRECATED,
    E_CORE_ERROR,
    E_CORE_WARNING,
    E_COMPILE_ERROR,
    E_COMPILE_WARNING,
    E_USER_ERROR,
    E_USER_WARNING,
    E_USER_NOTICE,
    E_USER_DEPRECATED,
    E_STRICT,
    E_ALL
);

/**
 *
 * @global array $GLOBALS['error-screen']
 * @name $error-screen 
 */
$GLOBALS['error-screen'] = array(
    E_USER_ERROR,
    E_USER_WARNING,
    E_USER_NOTICE,
    E_USER_DEPRECATED
);

/**
 *
 * @global array $GLOBALS['error-mail']
 * @name $error-mail 
 */
$GLOBALS['error-mail'] = array(
    E_ERROR,
    E_WARNING,
    E_PARSE,
    E_NOTICE,
    E_DEPRECATED,
    E_CORE_ERROR,
    E_CORE_WARNING,
    E_COMPILE_ERROR,
    E_COMPILE_WARNING,
    E_USER_ERROR,
    E_USER_WARNING,
    E_USER_NOTICE,
    E_USER_DEPRECATED,
    E_STRICT,
    E_ALL
);

/**
 *
 * @global array $GLOBALS['error-log']
 * @name $error-log 
 */
$GLOBALS['error-log'] = array(
    E_ERROR,
    E_WARNING,
    E_PARSE,
    E_NOTICE,
    E_DEPRECATED,
    E_CORE_ERROR,
    E_CORE_WARNING,
    E_COMPILE_ERROR,
    E_COMPILE_WARNING,
    E_USER_ERROR,
    E_USER_WARNING,
    E_USER_NOTICE,
    E_USER_DEPRECATED,
    E_STRICT,
    E_ALL
);
