<div class="mb-wrap">

    <main role="main" class="mb-main l-col--16">
        
        <h2>Contact</h2>
        <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>

        <form method="post" action="<?php echo PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR . 'contact/'; ?>">
            <div class="form-group"><input type="text" name="nachricht[name]" placeholder="Name" class="form-control"></div>
            <div class="form-group"><input type="text" name="nachricht[mail]" placeholder="E-Mail" class="form-control"></div>
            <div class="form-group"><textarea name="nachricht[message]" placeholder="Nachricht" class="form-control"></textarea></div>
            <button type="submit" name="nachricht[send]" class="btn btn-info">Senden</button>
        </form>

    </main>

    <?php require_once PROJECT_DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'core/tpl/aside.tpl.php'; ?>

</div>