<div id="contact" class="mb-wrap">

    <main role="main" class="mb-main l-col--16">

        <article class="article">
            <h2><?php echo $data['title']; ?></h2>
            <p><?php echo $data["content"]; ?></p>
        </article>

        <form method="post" action="<?php echo PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . 'contact/#contact'; ?>">
            <input type="hidden" name="csrf" value="<?php echo $data['csrf']; ?>">
            <fieldset class="mb-fieldset-border">
                <legend><?php _e('Contact'); ?></legend>
                <div class="mb-form__body">
                    <?php
                    if (!empty($data["success"])) {
                    ?>
                        <div class="mb-alert mb-alert-success">
                            <ul>
                                <?php
                                foreach ($data["success"] as $success) {
                                    echo '<li>' . $success . '</li>';
                                }
                                ?>
                            </ul>
                        </div>
                    <?php
                    }
                    ?>
                    <?php
                    if (!empty($data["errors"])) {
                    ?>
                        <div class="mb-alert mb-alert-warning">
                            <ul>
                                <?php
                                foreach ($data["errors"] as $error) {
                                    echo '<li>' . $error . '</li>';
                                }
                                ?>
                            </ul>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="mb-group">
                        <label><?php _e('Name'); ?></label>
                        <input type="text" name="name" placeholder="<?php _e('Name'); ?>">
                    </div>
                    <div class="mb-group">
                        <label><?php _e('E-Mail-Address'); ?></label>
                        <input type="text" name="email" placeholder="<?php _e('E-Mail-Address'); ?>">
                    </div>
                    <div class="mb-group">
                        <label><?php _e('Message'); ?></label>
                        <textarea name="message" placeholder="<?php _e('Message'); ?>"></textarea>
                    </div>
                    <div class="mb-action">
                        <button name="contact" class="mb-btn-primary"><?php _e('Send'); ?></button>
                    </div>
                </div>
            </fieldset>
        </form>

    </main>

    <?php require_once PROJECT_DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'core/tpl/aside.tpl.php'; ?>

</div>