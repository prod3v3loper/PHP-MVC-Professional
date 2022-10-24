<?php

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
