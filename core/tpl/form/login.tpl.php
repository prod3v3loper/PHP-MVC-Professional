<div class="mb-wrap">

    <main role="main" class="mb-main l-col--16">

        <h2>Contact</h2>
        <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>

        <form method="post" action="<?php echo PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . 'user/login/'; ?>">
            <input type="hidden" name="csrf" value="<?php echo $data['csrf']; ?>">
            <fieldset class="mb-fieldset-border"> 
                <legend>Login</legend> 
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
                        <input type="email" name="email" placeholder="Email">
                    </div>
                    <div class="mb-group"> 
                        <input type="password" name="password" placeholder="Password">
                    </div>
                    <div class="mb-group"> 
                        <small>
                            <a href="<?php echo PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . 'user/password/'; ?>">Password</a> - 
                            <a href="<?php echo PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . 'user/register/'; ?>">Register</a>
                        </small>
                    </div>
                    <div class="mb-action"> 
                        <button name="login" class="mb-btn-primary">Signin</button> 
                    </div> 
                </div>
            </fieldset>
        </form>

    </main>

    <?php require_once PROJECT_DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'core/tpl/aside.tpl.php'; ?>

</div>