<header class="container banner">
  <div class="content row">
    <div class="col-xs-12"><!-- TODO: XS - this might change to a two-line setup -->
      <div class="img"></div>
      <div class="callbox">
        <p class="cta">Call Us</p>
        <p class="number"><?php echo get_option('phone_number',"(888) 888-8888"); ?></p>
      </div>
      <nav class="nav-mini">
          <?php
            if (has_nav_menu('primary_mini_nav')) :
              wp_nav_menu(array('theme_location' => 'primary_mini_nav', 'menu_class' => 'nav nav-mini'));
            endif;
          ?>
      </nav>
    </div>
  </div>
</header>

<nav class="nav-main" role="navigation">
  <div class="container">
    <div class="content row">
      <div class="col-xs-12 nav-justify">
        <?php
          if (has_nav_menu('primary_navigation')) :
            wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav nav-blocks'));
          endif;
        ?>
      </div>
    </div>
  </div>
</nav>

<?php
  if (is_page() || is_home() || is_single()) {
    include_once locate_template('/lib/advance-edit-toolkit.php');
    generate_header();
  }
?>