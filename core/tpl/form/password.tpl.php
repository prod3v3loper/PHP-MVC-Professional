<div class="mb-wrap">

    <main role="main" class="mb-main l-col--16">

        <h2><?php echo $data['title']; ?></h2>
        <p><?php echo $data["content"]; ?></p>

        <form method="post" action="<?php echo PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . 'user/password/'; ?>">
            <input type="hidden" name="csrf" value="<?php echo $data['csrf']; ?>">
            <fieldset class="mb-fieldset-border">
                <legend>Password</legend>
                <div class="mb-form__body">
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
                        <input type="text" name="email" placeholder="E-Mail">
                    </div>
                    <div class="mb-group">
                        <small>
                            <a href="<?php echo PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . 'user/login/'; ?>">Login</a> -
                            <a href="<?php echo PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . 'user/register/'; ?>">Register</a>
                        </small>
                    </div>
                    <div class="mb-action">
                        <button name="pass" class="mb-btn-primary">Send</button>
                    </div>
                </div>
            </fieldset>
        </form>

    </main>

    <?php require_once PROJECT_DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'core/tpl/aside.tpl.php'; ?>

</div>