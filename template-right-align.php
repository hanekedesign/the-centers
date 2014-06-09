<?php
/*
Template Name: Right-Aligned Template
*/
include_once locate_template('/lib/advance-edit-toolkit.php');

$panelmode = get_panel_mode(); 

function get_body_css_class($id) {
  switch ($id) {
    case 0:
      return "col-xs-12";
    case 1:
      return "col-md-8 col-xs-12";
    case 2:
      return "col-sm-8 col-xs-12";
  }
}

?>

<div class="container page">
  <div class="row">
    <?php ?>
    <div class="page-body <?php echo get_body_css_class($panelmode); ?>">
      <?php get_template_part('templates/content', 'page'); ?>
    </div>
    <?php generate_panel(""); ?>
  </div>
</div>
