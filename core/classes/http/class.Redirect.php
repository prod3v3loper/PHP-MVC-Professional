<?php

namespace core\classes\http;

/**
 * Description of Redirect
 *
 * @author      prod3v3loper
 * @copyright   (c) 2021, Samet Tarim
 * @link        https://www.prod3v3loper.com
 * @package     melabuai
 * @subpackage  mvc
 * @version     1.0
 * @since       1.0
 */
abstract class Redirect
{
    /**
     * Standart redirect
     * 
     * This function will definitely guide you further, as it will use all the possibilities. 
     * This means that when PHP headers have been sent, JavaScript will try to forward them to the appropriate URL, 
     * if this also fails. No javascript available or for whatever reason, you will be forwarded via HTML meta tag
     * 
     * @uses $location = 'https://mydomain.com/params="1"';
     * _MBT_Redirect::to($location); This is treated as a normal header redirect.
     * 
     * @param string $location
     */
    public static function to($location)
    {
        // If PHP header not send ?
        if (!headers_sent()) {
            header("Location: $location");
            exit();
        }
        //.. Otherwise is script send with JS otherwise send with html
        else {
?>
            <script type="text/javascript">
                location.href = '<?php echo $location; ?>';
            </script>
            <noscript>
                <meta http-equiv="refresh" content="0; URL=<?php echo $location; ?>">
            </noscript>
<?php
        }
    }

    /**
     * Individual redirect with type code
     * 
     * @uses $args = array(
     *      'redirect' => 301
     *      'redirects' => array(
     *          "redirect-url-1" => "redirected-url-1",
     *          "redirect-url-2" => "redirected-url-2",
     *      )
     * ) 
     * _MBT_Redirect::redirect($args); This is a example, to show usage. The static function was called and args inserted
     * 
     * @param array $args
     */
    public static function toall(array $args = array())
    {
        $redirects = $args['redirects'];
        if (in_array(get_request_uri(), array_keys($redirects))) {
            foreach ($redirects as $redirectKey => $redirectValue) {
                if (get_request_uri() == trim($redirectKey)) {
                    header("Location: " . $redirectValue, true, $args['redirect']);
                    exit();
                }
            }
        }
    }
}
