<?php

/**
 * Get the URL protocol
 * 
 * @return string
 */
function get_protocol()
{
    $HTTPS = (isset($_SERVER['HTTPS']) ? $_SERVER['HTTPS'] : '');
    $protocol = !isset($HTTPS) || $HTTPS != 'on' ? 'http://' : 'https://';
    return $protocol;
}

/**
 * Get the Host
 * 
 * @return string
 */
function get_host()
{
    return (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '');
}

/**
 * Get the request uri
 * 
 * @return string
 */
function get_request_uri()
{
    return get_protocol() . get_host() . filter_input(INPUT_SERVER, 'REQUEST_URI');
}
