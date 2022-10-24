<?php
// All from the controller is in $data
// var_dump($data);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        
        <title><?php echo (isset($data['title']) && $data['title'] ? $data['title'] : ''); ?> - <?= WEBSITE_NAME ?></title>
        <meta name="description" content="<?= (isset($data['description']) && $data['description'] ? $data['description'] : ''); ?>">
        <meta name="robots" content="<?= ($data['robots'] != '1' ? $data['robots'] : 'noindex, nofollow, noodp'); ?>">
        
        <link href="<?= PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR; ?>core/css/style.min.css" rel="stylesheet" type="text/css">
        
        <!-- Favicon Mobile to Desktop -->
        <link rel="shortcut icon" href="<?= PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR; ?>favicon.ico">
        <link rel="icon" type="image/png" href="<?= PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR; ?>favicon.png" sizes="32x32">
        <link rel="apple-touch-icon" sizes="180x180" href="<?= PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR; ?>favicon.png">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?= PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR; ?>favicon.png">

        <!-- Mobile task color -->
        <meta name="theme-color" content="#ffffff"><!-- Windows Phone -->
        <meta name="msapplication-navbutton-color" content="#ffffff"><!-- iOS Safari -->
        <meta name="apple-mobile-web-app-status-bar-style" content="#ffffff"> <!-- Chrome, Firefox OS, Opera and Vivaldi -->

        <!-- Transfer of each controller data to this default index and use it here or in the templates -->
        <?php
        // Collect variables for js and use it in js files
        $data['js-collector'] = array(
            "httproot" => PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR,
        );
        ?>
        <script>
            var maa_js = <?php echo (isset($data['js-collector']) ? json_encode($data['js-collector']) : '') ?>;
        </script>
    </head>
    <body>
        <?php
        if (isset($data['templates'])) {
            // If templates loop it
            foreach ($data['templates'] as $template) {
                // Create template file path
                $file = PROJECT_DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'core/tpl' . DIRECTORY_SEPARATOR . $template . '.tpl.php';
                // Check if exitst and load
                if (file_exists($file)) {
                    require_once $file;
                } else {
                    echo 'Tpl not found!';
                }
            }
        }
        ?>
        <script src="<?php echo PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR; ?>/js/frontend.js" type="text/javascript"></script>
    </body>
</html>