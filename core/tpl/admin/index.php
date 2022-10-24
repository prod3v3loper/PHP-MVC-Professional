<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>MVC Professional by prod3v3loper</title>
        <link href="<?php echo PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR; ?>core/css/style.min.css" rel="stylesheet" type="text/css">
        <!-- Add more, everything you need for your project -->
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
                }
            }
        }
        ?>
        <script src="<?php echo PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR; ?>/js/backend.js" type="text/javascript"></script>
    </body>
</html>