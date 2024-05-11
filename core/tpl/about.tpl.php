<div class="mb-wrap">

    <main role="main" class="mb-main l-col--16">
        <article class="article">
            <h2><?php echo $data['title']; ?></h2>
            <p><?php echo $data["content"]; ?></p>
        </article>
    </main>

    <?php require_once PROJECT_DOCUMENT_ROOT . DIRECTORY_SEPARATOR . 'core/tpl/aside.tpl.php'; ?>

</div>