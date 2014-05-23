<header class="banner container" role="banner">
  <div class="row">
    <div class="col-lg-9">
      <a class="brand" href="<?php echo home_url('/') ?>"><?php bloginfo('name'); ?></a>
      <nav class="nav-main" role="navigation">
        <?php
          if (has_nav_menu('primary_navigation')) :
            wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav nav-pills'));
          endif;
        ?>
      </nav>
    </div>
    <div class="callbox col-lg-3">
      <p>CALL US</p><!-- TODO: Editable -->
      <p class="phonenumber">(888) 888 8888</p><!-- TODO: Editable -->
    </div>
  </div>
</header>
