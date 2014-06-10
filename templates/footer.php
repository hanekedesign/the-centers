<?php
  include_once locate_template('/lib/advance-edit-toolkit.php');
  generate_footer();
?>

<footer class="foot-contact" role="contentinfo">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <a href="tel:<?php echo preg_replace("/[^0-9]/","",get_option('phone_number',"(888) 888-8888")); ?>" class="number">Call <?php echo get_option('phone_number',"(888) 888-8888"); ?></a>
        <a href="/contact/" class="contact">+ Contact Us Online</a>
      </div>
    </div>
  </div>
</footer>

<footer class="foot-main" role="contentinfo">
  <div class="container">
    <div class="row">
      <div class="col-sm-5">
        <form class="newsletter sidebar-box">
          <label for="male">Sign Up for Our Newsletter</label><br>
          <input type="email" name="email" id="email" placeholder="Your email address"><br>
          <button type="submit" value="Submit">Sign up</button>
        </form>
        <?php get_search_form_with_label(true,"Search the Site"); ?>
      </div>
      <div class="col-sm-3 col-sm-offset-1 footer-menu-pad">
        <?php
          if (has_nav_menu('footer_nav_left')) :
            wp_nav_menu(array('theme_location' => 'footer_nav_left', 'menu_class' => 'nav nav-footer'));
          endif;
        ?>
      </div>
      <div class="col-sm-2 footer-menu-pad">
        <?php
          if (has_nav_menu('footer_nav_right')) :
            wp_nav_menu(array('theme_location' => 'footer_nav_right', 'menu_class' => 'nav nav-footer'));
          endif;
        ?>
      </div>
      <div class="col-sm-1 col-xs-12 footer-menu-pad socialbox">
        <?php echo do_shortcode('[social type="home" method="link"]'); ?>
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

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-51004127-1', 'centersweb.com');
  ga('send', 'pageview')
</script> 

<?php wp_footer(); ?>
