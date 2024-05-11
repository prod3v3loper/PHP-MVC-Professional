<?php

/**
 * 
 * @return integer float
 */
function start_time()
{
    $timeExplode = explode(" ", microtime());
    $time = $timeExplode[1] + $timeExplode[0];
    return (float) $time;
}

/**
 * 
 * @param integer $timer
 * 
 * @return integer float
 */
function end_time($timer)
{
    $timeExplode = explode(" ", microtime());
    $time = $timeExplode[1] + $timeExplode[0];
    $finish = $time - $timer;
    $endTime = sprintf("%4.3f", $finish);
    return (float) $endTime;
}
