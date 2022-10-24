<?php

/**
 * Output the data with pre and var_dump()
 * 
 * @see http://php.net/manual/de/function.var-dump.php
 * 
 * @param mixed $data
 */
function _evd($data)
{
    echo '<pre class="pre">';
    echo var_dump($data);
    echo '</pre>';
}
