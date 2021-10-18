<?php

/**
 * Database settings
 */

define('DB_PREFIX', 'w_');
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_NAME', 'dbname');
define('DB_DSN', 'mysql:host=' . DB_HOST . ':' . DB_PORT . ';dbname=' . DB_NAME);
define('DB_USER', 'root');
define('DB_PASS', 'password');

// Debug
define('DEBUG', true);
