<?php
/*
Template Name: FAQ Template
*/
include_once locate_template('/lib/advance-edit-toolkit.php');
$header = get_post_meta( $post->ID, 'advedit_faq_root_title', true )?:"";
$body = get_post_meta( $post->ID, 'advedit_faq_root_body', true )?:"";
$titles = get_post_meta( $post->ID, 'advedit_faq_question', true )?:array();
$texts = get_post_meta( $post->ID, 'advedit_faq_answer', true )?:array();
?>

<div class="container page">
  <div class="row">
    <?php $panelmode = generate_panel(); ?>    
    <div class="col-xs-<?php echo ($panelmode == 0)?8:8; ?>">     
      <div class="faq">
      <?php 
        for ($i = 0; $i < count($titles); $i++) {
          ?>
            <div class="accordion">
              <div class="title"><?php echo $titles[$i]?:"text"; ?></div>
              <div class="body"><?php echo $texts[$i]?:""; ?></div>
            </div>
          <?php
        }
      ?>
      </div>
    </div>
  </div>
</div>
