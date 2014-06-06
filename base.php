<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>

  <!--[if lt IE 8]>
    <div class="alert alert-warning">
      <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'roots'); ?>
    </div>
  <![endif]-->

  <?php
    do_action('get_header');
    // Use Bootstrap's navbar if enabled in config.php
    if (current_theme_supports('bootstrap-top-navbar')) {
      get_template_part('templates/header-top-navbar');
    } else {
      get_template_part('templates/header');
    }
  ?>

  <?php if ($_REQUEST['from-form']==true) : ?>
  <div class="container">
    <div class="row">
      <div class="col-xs-12 page-body">
        <br/>
        <div class="alert alert-success"><strong>Success!</strong> Your information has been sent.</div>
      </div>
    </div>
  </div>
  <?php endif ?>

  <main role="main">
    <?php include roots_template_path(); ?>
  </main><!-- /.main -->
  
  <?php get_template_part('templates/footer'); ?>

</body>
</html>
