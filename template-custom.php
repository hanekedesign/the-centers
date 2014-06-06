<?php
/*
Template Name: Simple Template
*/
?>

<div class="container page">
  <div class="row">
    <?php $panelmode = generate_panel(); ?>    
    <div class="col-xs-12">     
      <?php get_template_part('templates/content', 'page'); ?>
    </div>
  </div>
</div>