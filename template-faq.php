<?php
/*
Template Name: FAQ Template
*/
include_once locate_template('/lib/advance-edit-toolkit.php');
$header = get_post_meta( $post->ID, 'advedit_faq_root_title', true )?:"";
$body = get_post_meta( $post->ID, 'advedit_faq_root_body', true )?:"";
$titles = get_post_meta( $post->ID, 'advedit_faq_question', true )?:array();
$texts = get_post_meta( $post->ID, 'advedit_faq_answer', true )?:array();

$panelmode = get_panel_mode(); 

function get_body_css_class($id) {
  switch ($id) {
    case 0:
      return "col-xs-12";
    case 1:
      return "col-md-8 col-xs-12" . " col-md-push-4";
    case 2:
      return "col-sm-8 col-xs-12" . " col-sm-push-4";
  }
}

?>

<div class="container page">
  <div class="row">
    <div class="col-md-8 col-xs-12 col-md-push-4">     
      <div class="faq">
      <?php 
        for ($i = 0; $i < count($titles); $i++) {
          ?>
            <div class="accordion">
              <div class="title"><?php echo $titles[$i]?:"text"; ?></div>
              <div class="body"><?php echo html_entity_decode($texts[$i])?:""; ?></div>
            </div>
          <?php
        }
      ?>
      </div>
    </div>
    <?php $panelmode = generate_panel("col-sm-pull-8 visible-md visible-lg"); ?>    
  </div>
</div>
