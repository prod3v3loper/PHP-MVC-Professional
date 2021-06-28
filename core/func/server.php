<?php

/**
 * Add more function files in this folder all was required in the com.php automtic
 */

/**
 * Get the URL protocol
 * 
 * @return type String
 */
function get_protocol() {

    $HTTPS = (isset($_SERVER['HTTPS']) ? $_SERVER['HTTPS'] : '');
    $protocol = !isset($HTTPS) || $HTTPS != 'on' ? 'http://' : 'https://';
    return $protocol;
}

/**
 * Get the Host
 * 
 * @return type String
 */
function get_host() {

    return (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
}

/**
 * Get the request uri
 * 
 * @return type String
 */
function get_request_uri() {

    return get_protocol() . get_host() . filter_input(INPUT_SERVER, 'REQUEST_URI');
}
