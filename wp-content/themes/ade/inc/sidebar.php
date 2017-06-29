<nav id="main-menu" class="hidden-sm hidden-xs">
<?php echo
    wp_nav_menu( array(
    'menu_id' => 2,
    'container' => 'ul',
    'echo' => false
    ) );
?>

    <div class="c-sidebar__widget">
    <h4>Newsletter</h4>
    <p>Sign up to receive exclusive offers, the latest news, and
        access to the newest audio/video uploads.</p>
    <button class="btn--primary">
        Subscribe
    </button>
    </div>
</nav>
