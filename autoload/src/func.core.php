<?php

/**
 * 
 * @return type float
 */
function start_time() {

    $timeExplode = explode(" ", microtime());
    $time = $timeExplode[1] + $timeExplode[0];
    return (float) $time;
}

/**
 * 
 * @param type $timer
 * @return type float
 */
function end_time($timer) {

    $timeExplode = explode(" ", microtime());
    $time = $timeExplode[1] + $timeExplode[0];
    $finish = $time - $timer;
    $endTime = sprintf("%4.3f", $finish);
    return (float) $endTime;
}