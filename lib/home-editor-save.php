<?php
  global $post;
  $post_id = $post->ID;

  // Check if our nonce is set.
  if ( ! isset( $_POST['home_meta_nonce'] ) ) { return; }

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $_POST['home_meta_nonce'], 'home_meta' ) ) { return; }

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

  update_post_meta( $post_id, 'home_largebox_header_image_0', esc_html($_POST['home_largebox_header_image_0']?:""));
  update_post_meta( $post_id, 'home_largebox_header_image_1', esc_html($_POST['home_largebox_header_image_1']?:""));
  update_post_meta( $post_id, 'home_largebox_header_image_2', esc_html($_POST['home_largebox_header_image_2']?:""));

  update_post_meta( $post_id, 'home_largebox_header_0', esc_html($_POST['home_largebox_header_0']?:""));
  update_post_meta( $post_id, 'home_largebox_header_1', esc_html($_POST['home_largebox_header_1']?:""));
  update_post_meta( $post_id, 'home_largebox_header_2', esc_html($_POST['home_largebox_header_2']?:""));

  update_post_meta( $post_id, 'home_largebox_subheader_first_0', esc_html($_POST['home_largebox_subheader_first_0']?:""));
  update_post_meta( $post_id, 'home_largebox_subheader_first_1', esc_html($_POST['home_largebox_subheader_first_1']?:""));
  update_post_meta( $post_id, 'home_largebox_subheader_first_2', esc_html($_POST['home_largebox_subheader_first_2']?:""));

  update_post_meta( $post_id, 'home_largebox_subheader_second_0', esc_html($_POST['home_largebox_subheader_second_0']?:""));
  update_post_meta( $post_id, 'home_largebox_subheader_second_1', esc_html($_POST['home_largebox_subheader_second_1']?:""));
  update_post_meta( $post_id, 'home_largebox_subheader_second_2', esc_html($_POST['home_largebox_subheader_second_2']?:""));

  update_post_meta( $post_id, 'home_largebox_header_text', esc_html($_POST['home_largebox_header_text']?:""));
  update_post_meta( $post_id, 'home_largebox_header_link_text', esc_html($_POST['home_largebox_header_link_text']?:""));
  update_post_meta( $post_id, 'home_largebox_header_link', esc_html($_POST['home_largebox_header_link']?:""));

  for ($i = 0; $i < 4; $i++) {
    update_post_meta( $post_id, 'home_minibox_header_'.$i, esc_html($_POST['home_minibox_header_'.$i]?:""));
    update_post_meta( $post_id, 'home_minibox_text_'.$i, esc_html($_POST['home_minibox_text_'.$i]?:""));
    update_post_meta( $post_id, 'home_minibox_link_'.$i, esc_html($_POST['home_minibox_link_'.$i]?:""));
    update_post_meta( $post_id, 'home_minibox_link_text_'.$i, esc_html($_POST['home_minibox_link_text_'.$i]?:""));
    update_post_meta( $post_id, 'home_minibox_color_'.$i, esc_html($_POST['home_minibox_color_'.$i]?:""));
  }

  update_post_meta( $post_id, 'home_footer_header', esc_html($_POST['home_footer_header']?:""));
  update_post_meta( $post_id, 'home_footer_content', esc_html($_POST['home_footer_content']?:""));
  update_post_meta( $post_id, 'home_footer_button_text', esc_html($_POST['home_footer_button_text']?:""));
  update_post_meta( $post_id, 'home_footer_button_link', esc_html($_POST['home_footer_button_link']?:""));
  update_post_meta( $post_id, 'home_footer_image', esc_html($_POST['home_footer_image']?:0));
        
  /*$prefix = "contact_form_0_";
  
  if (isset($_POST['advedit_contact_header'])) {
    addOrUpdateGlobalOption($prefix.'_header',$_POST['advedit_contact_header']);
  }
  if (isset($_POST['advedit_contact_form'])) {
    addOrUpdateGlobalOption($prefix.'_form',$_POST['advedit_contact_form']);
  }*/
?>