<?php
  global $post;
  $post_id = $post->ID;

  // Check if our nonce is set.
  if ( ! isset( $_POST['advedit_meta_nonce'] ) ) { die('a'); return; }

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $_POST['advedit_meta_nonce'], 'advedit_meta' ) ) { die('b'); return; }

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { die('c'); return; }

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

  update_post_meta( $post_id, 'advedit_panelmode', $_POST['adved_panelselect'] );
  update_post_meta( $post_id, 'advedit_image_blurb', $_POST['advedit_image_blurb']);
  update_post_meta( $post_id, 'advedit_header_mode', $_POST['advedit_header_mode']);
  update_post_meta( $post_id, 'advedit_header_color', $_POST['advedit_header_color']);
    
  update_post_meta( $post_id, 'advedit_sidebar_form_type', $_POST['sidebar_form_type'] );
  update_post_meta( $post_id, 'advedit_sidebar_form_text', $_POST['sidebar_form_text'] );
  update_post_meta( $post_id, 'advedit_sidebar_form_name', $_POST['sidebar_form_name'] );
  update_post_meta( $post_id, 'advedit_sidebar_form_placeholder', $_POST['sidebar_form_placeholder'] );
  update_post_meta( $post_id, 'advedit_sidebar_form_value', $_POST['sidebar_form_value'] );

  if (isset($_POST['advedit_contact_header'])) {
    addOrUpdateGlobalOption('contact_header',$_POST['advedit_contact_header']);
  }
  if (isset($_POST['advedit_contact_form'])) {
    addOrUpdateGlobalOption('contact_form',$_POST['advedit_contact_form']);
  }
?>