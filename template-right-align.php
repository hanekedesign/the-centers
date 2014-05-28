<?php
/*
Template Name: Right-Aligned Template
*/
include_once locate_template('/lib/advance-edit-toolkit.php');
$panelmode = get_panel_mode();
$right_aligned = 1;
?>

<div class="container page">
  <div class="row">
    <div class="col-xs-<?php echo ($panelmode == 0)?12:8; ?> page-body">
      <?php get_template_part('templates/content', 'page'); ?>
    </div>
    <?php $panelmode = generate_panel(); ?>
  </div>
</div>
