<?php

/**
 * 
 * @param type $echo
 * @param type $args
 * @param type $lang
 * 
 * @return type
 */
function __($echo, $args = array())
{
    $return = $echo;

    $langFile = PROJECT_DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'includes/lang' . DIRECTORY_SEPARATOR . (isset($_SESSION['language']) ? $_SESSION['language'] . '_' . (isset($_SESSION['language']) ? strtoupper($_SESSION['language']) : "") . '.json' : '');

    if (is_array($args)) {
        $args = array_filter($args);
        if (!empty($args)) {
            $return = str_replace($args['keys'], $args['values'], $echo);
        }
    }

    if (file_exists($langFile)) {
        $langFileInner = file_get_contents($langFile);
        $langFileInnerDecode = json_decode($langFileInner, true);
        if (is_array($langFileInnerDecode)) {
            foreach ($langFileInnerDecode as $lang => $translated) {
//            $pos = strpos($echo, $lang);
//            if ($pos !== false) {
//                $return = str_replace(substr($echo, $pos, strlen($lang)), $translated, $echo);
//            }
                if (strtolower($echo) == strtolower($lang)) {
                    $state = starts_with_upper($echo);
                    $return = $state ? ucfirst($translated) : $translated;
                }
            }
        }
    }

    return $return;
}

/**
 * 
 * @param type $echo
 * @param type $args
 * @param type $lang
 */
function _e($echo, $args = array())
{
    $return = $echo;

    $langFile = PROJECT_DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'includes/lang' . DIRECTORY_SEPARATOR . (isset($_SESSION['language']) ? $_SESSION['language'] . '_' . (isset($_SESSION['language']) ? strtoupper($_SESSION['language']) : "") . '.json' : '');

    if (file_exists($langFile)) {

        if (is_array($args)) {
            $args = array_filter($args);
            if (!empty($args)) {
                $return = str_replace($args['keys'], $args['values'], $echo);
            }
        }

        $langFileInner = file_get_contents($langFile);
        $langFileInnerDecode = json_decode($langFileInner, true);
        if (is_array($langFileInnerDecode)) {
            foreach ($langFileInnerDecode as $lang => $translated) {
//            $pos = strpos($echo, $lang);
//            if ($pos !== false) {
//                $return = str_replace(substr($echo, $pos, strlen($lang)), $translated, $echo);
//            }
                if (strtolower($echo) == strtolower($lang)) {
                    $state = starts_with_upper($echo);
                    $return = $state ? ucfirst($translated) : $translated;
                }
            }
        }
    }

    echo $return;
}

/**
 * 
 * @param type $str
 * 
 * @return type
 */
function starts_with_upper($str)
{
    $chr = mb_substr($str, 0, 1, "UTF-8");
    return mb_strtolower($chr, "UTF-8") != $chr;
}
