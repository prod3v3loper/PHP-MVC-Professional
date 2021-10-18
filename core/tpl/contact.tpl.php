<div class="mb-wrap">

    <main role="main" class="mb-main l-col--16">

        <h2>Contact</h2>
        <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>

        <form method="post" action="<?php echo PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . 'contact/'; ?>">
            <input type="text" name="name" placeholder="Name" class="form-control">
            <input type="text" name="email" placeholder="E-Mail" class="form-control">
            <textarea name="message" placeholder="Message" class="form-control"></textarea>
            <button type="submit" name="Send" class="btn btn-info">Send</button>
        </form>

    </main>

    <?php require_once PROJECT_DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'core/tpl/aside.tpl.php'; ?>

</div>