<?php
/*
Template Name: About Template
*/
?>

<div class="container page about-page">
  <div class="row">
    <?php $panelmode = generate_panel(); ?>    
    <div class="col-xs-8 col-xs-offset-2"> 
      <div class="form">
        <?php echo do_shortcode(html_entity_decode(get_post_meta( $post->ID, 'advedt_about_form', true )))?:""; ?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-5 col-xs-offset-2">
      <p class="phone-number"><?php echo get_option('phone_number',"(888) 888-8888"); ?></p>
    </div>
    <div class="col-xs-3">
      <div class="contact-header">
        <?php echo get_post_meta( $post->ID, 'advedt_about_contact_header', true )?:""; ?>
      </div>
      <div class="contact-address">
        <?php echo get_post_meta( $post->ID, 'advedt_about_contact_address', true )?:""; ?>
      </div>
    </div>
    
  </div>
</div>