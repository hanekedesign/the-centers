<?php
  global $post;
  $post_id = $post->ID;

  // Check if our nonce is set.
  if ( ! isset( $_POST['advedit_meta_nonce'] ) ) { return; }

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $_POST['advedit_meta_nonce'], 'advedit_meta' ) ) {  return; }

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }

  // Check the user's permissions.
  if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
      if ( ! current_user_can( 'edit_page', $post_id ) ) {
          return;
      }
  } else {
      if ( ! current_user_can( 'edit_post', $post_id ) ) {
          return;
      }
  }

  update_post_meta( $post_id, 'advedit_panelmode', $_POST['adved_panelselect']?:0 );
  update_post_meta( $post_id, 'advedit_image_blurb', $_POST['advedit_image_blurb']?:"");
    
  update_post_meta( $post_id, 'advedit_sidebar_form_header', $_POST['sidebar_form_header']?:0 );
  update_post_meta( $post_id, 'advedit_sidebar_form_color', $_POST['sidebar_form_color']?:"primary" );
  update_post_meta( $post_id, 'advedit_sidebar_form_type', $_POST['sidebar_form_type']?:0 );
  update_post_meta( $post_id, 'advedit_sidebar_form_text', $_POST['sidebar_form_text']?:"" );
  update_post_meta( $post_id, 'advedit_sidebar_form_name', $_POST['sidebar_form_name']?:"" );
  update_post_meta( $post_id, 'advedit_sidebar_form_placeholder', $_POST['sidebar_form_placeholder']?:"" );
  update_post_meta( $post_id, 'advedit_sidebar_image', $_POST['advedit_sidebar_image']?:"" );
  update_post_meta( $post_id, 'advedit_sidebar_sibling_menu', $_POST['advedt_siblemenu']?:false );

  update_post_meta( $post_id, 'advedit_header_mode', $_POST['advedit_header_mode']?:"");
  update_post_meta( $post_id, 'advedit_header_color', $_POST['advedit_header_color']?:"");
  update_post_meta( $post_id, 'advedit_header_text', $_POST['advedit_header_text']?:"");
  update_post_meta( $post_id, 'advedit_header_image', $_POST['advedit_header_image']?:"");
  update_post_meta( $post_id, 'advedit_header_title', $_POST['advedit_header_title']?:"");

  update_post_meta( $post_id, 'advedit_footer_mode', $_POST['advedit_footer_mode']?:"");

  // FAQ Data
  update_post_meta( $post_id, 'advedit_faq_root_title', $_POST['faq_root_title']?:"");
  update_post_meta( $post_id, 'advedit_faq_root_body', $_POST['faq_root_body']?:"");
  update_post_meta( $post_id, 'advedit_faq_question', $_POST['faq_title']?:"");
  update_post_meta( $post_id, 'advedit_faq_answer', $_POST['faq_text']?:"");

  // Footer
  update_post_meta( $post_id, 'advedt_widebox_header', $_POST['advedt_widebox_header']?:"");
  update_post_meta( $post_id, 'advedt_widebox_button_label', $_POST['advedt_widebox_button_label']?:"");
  update_post_meta( $post_id, 'advedt_widebox_button', $_POST['advedt_widebox_button']?:"");
  update_post_meta( $post_id, 'advedt_widebox_button_two_label', $_POST['advedt_widebox_button_two_label']?:"");
  update_post_meta( $post_id, 'advedt_widebox_button_two', $_POST['advedt_widebox_button_two']?:"");

  for ($i = 0; $i < 4; $i++) {
    if (!isset($_POST['advedt_minibox_text_'.$i])) {continue;};
    update_post_meta( $post_id, 'advedt_minibox_header_'.$i, $_POST['advedt_minibox_header_'.$i]?:"");
    update_post_meta( $post_id, 'advedt_minibox_text_'.$i, $_POST['advedt_minibox_text_'.$i]?:"");
    update_post_meta( $post_id, 'advedt_minibox_link_'.$i, $_POST['advedt_minibox_link_'.$i]?:"");
    update_post_meta( $post_id, 'advedt_minibox_link_text_'.$i, $_POST['advedt_minibox_link_text_'.$i]?:"");
    update_post_meta( $post_id, 'advedt_minibox_color_'.$i, $_POST['advedt_minibox_color_'.$i]?:"");
  }

  /*$prefix = "contact_form_0_";
  
  if (isset($_POST['advedit_contact_header'])) {
    addOrUpdateGlobalOption($prefix.'_header',$_POST['advedit_contact_header']);
  }
  if (isset($_POST['advedit_contact_form'])) {
    addOrUpdateGlobalOption($prefix.'_form',$_POST['advedit_contact_form']);
  }*/
?>