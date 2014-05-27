<?php
  include_once locate_template('/lib/advance-edit-toolkit.php');
  generate_footer();
?>

<footer class="foot-contact" role="contentinfo">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="number">Call (888) 888-8888</div>
        <div class="contact">+ Contact Us Online</div>
      </div>
    </div>
  </div>
</footer>

<footer class="foot-main" role="contentinfo">
  <div class="container">
    <div class="row">
      <div class="col-xs-5">
        <form class="newsletter">
          <label for="male">Sign Up for Our Newsletter</label><br>
          <input type="email" name="email" id="email" placeholder="Your email address"><br>
          <button type="submit" value="Submit">Sign up</button>
        </form>
        <?php get_search_form_with_label(true,"Search the Site"); ?>
      </div>
      <div class="col-xs-3 col-xs-offset-1 footer-menu-pad">
        <?php
          if (has_nav_menu('footer_nav_left')) :
            wp_nav_menu(array('theme_location' => 'footer_nav_left', 'menu_class' => 'nav nav-footer'));
          endif;
        ?>
      </div>
      <div class="col-xs-2 footer-menu-pad">
        <?php
          if (has_nav_menu('footer_nav_right')) :
            wp_nav_menu(array('theme_location' => 'footer_nav_right', 'menu_class' => 'nav nav-footer'));
          endif;
        ?>
      </div>
      <div class="col-xs-1 footer-menu-pad">
        <a href="#" class="icon linkedin"></a>
      </div>
    </div>
  </div>
</footer>

<footer class="foot-copyright" role="contentinfo">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
         <div class="copy">
          <?php
            if (has_nav_menu('footer_nav_mini')) :
              wp_nav_menu(array('theme_location' => 'footer_nav_mini', 'menu_class' => 'nav nav-footer-left'));
            endif;
          ?> <p>Copyright 2014 by The Centers</p>
        </div>
      </div>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
