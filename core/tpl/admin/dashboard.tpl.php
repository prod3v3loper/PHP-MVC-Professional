<div class="mb-wrap">

    <main role="main" class="mb-main l-col--16">

        <article class="mb-article">
            <h2><?php echo $data['title']; ?></h2>
            <p><?php echo $data["content"]; ?></p>
        </article>

        <form method="post" action="<?php echo PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . 'admin/logout/'; ?>">
            <input type="hidden" name="csrf" value="<?php echo $data['csrf']; ?>">
            <fieldset class="mb-fieldset-border">
                <legend>Logout</legend>
                <div class="mb-form__body">
                    <div class="mb-group">
                        <?php
                        echo $data['user']->getFirstname() . '<br>';
                        echo $data['user']->getLastname() . '<br>';
                        echo $data['user']->getEmail();
                        ?>
                    </div>
                    <div class="mb-action">
                        <button name="login" class="mb-btn-primary">Logout</button>
                    </div>
                </div>
            </fieldset>
        </form>

    </main>

    <?php require_once PROJECT_DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'core/tpl/aside.tpl.php'; ?>

</div>