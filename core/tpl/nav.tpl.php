<nav role="navigation" id="mb-nav" class="mb-night-nav mb-col-24">
    <div class="mb-nav--inner">
        <div class="mb-container">
            <a class="mb-nav--brand" href="<?php echo PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR; ?>">Melabuai MVC Professional</a>
            <ul class="mb-nav--navbar mb-nav--list">
                <li class="mb-nav--navbar-item"><a <?php echo isset($active) && $active == 'home' ? 'class="mb-nav--active"' : '' ?> href="<?php echo PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR; ?>">Home</a></li>
                <li class="mb-nav--navbar-item"><a <?php echo isset($active) && $active == 'about' ? 'class="mb-nav--active"' : '' ?> href="<?php echo PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR; ?>about/">About</a></li>
                <li class="mb-nav--navbar-item"><a <?php echo isset($active) && $active == 'blog' ? 'class="mb-nav--active"' : '' ?> href="<?php echo PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR; ?>blog/">Blog</a></li>
                <li class="mb-nav--navbar-item"><a <?php echo isset($active) && $active == 'contact' ? 'class="mb-nav--active"' : '' ?> href="<?php echo PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR; ?>contact/">Contact</a></li>
                <li class="mb-nav--navbar-item"><a <?php echo isset($active) && $active == 'support' ? 'class="mb-nav--active"' : '' ?> href="<?php echo PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR; ?>support/">Support</a></li>
                <li class="mb-nav--navbar-item"><small><a class="mb-btn mb-btn-primary" href="<?php echo PROJECT_HTTP_ROOT . DIRECTORY_SEPARATOR; ?>user/login/">Login</a></small></li>
            </ul>
            <a class="mb-nav--mobile-btn mb-nav--show" href="#mb-nav"><span></span><span></span><span></span></a>
            <a class="mb-nav--mobile-btn mb-nav--hide" href="#"><span></span><span></span><span></span></a>
        </div>
    </div>
</nav>