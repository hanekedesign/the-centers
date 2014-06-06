<?php
/*
Template Name: Left-Aligned Template
*/
include_once locate_template('/lib/advance-edit-toolkit.php');
$align = 0;
?>

<div class="container page">
  <div class="row">
    <?php $panelmode = generate_panel(); ?>
    <div class="col-sm-<?php echo ($panelmode == 0)?12:8; ?> col-xs-12 page-body">
      <?php get_template_part('templates/content', 'page'); ?>
    </div>
  </div>
</div>
