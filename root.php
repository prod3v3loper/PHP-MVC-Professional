<?php

if (DEBUG) {
    // Overwrite ini settings debug
    ini_set('html_errors', 1);
    ini_set('error_reporting', -1); // E_ALL
    ini_set('display_errors', 1); // On
    error_reporting(-1); // Report all
}

/**
 * Define dynamic project root to read, create and link
 * 
 * PROJECT_DOCUMENT_ROOT = Project complete root path
 * DOCUMENT_ROOT = Project folder root path
 * PROJECT_HTTP_ROOT = Your http root url
 */
define('PROJECT_DOCUMENT_ROOT', __DIR__);
define('DOCUMENT_ROOT', str_replace(PROJECT_DOCUMENT_ROOT, '', str_replace(filter_input(INPUT_SERVER, 'DOCUMENT_ROOT'), '', str_replace("\\", "/", __DIR__))));
define('PROJECT_HTTP_ROOT', get_protocol() . get_host() . DOCUMENT_ROOT);
