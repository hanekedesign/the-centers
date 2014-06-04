<?php

function render_image_box() {
  global $post;
  wp_nonce_field( 'extensions_meta_box', 'extensions_meta_box_nonce' );
  $image = wp_get_attachment_image_src( get_post_meta($post->ID, 'extensions_header_image', TRUE)?:0 , 'full' )?:Array();
  ?>
    <div class="imgsel" style="background-image: url('<?php echo $image[0]; ?>')">
      <input type="hidden" name="header-img">
    </div>
  <?php
}

function init_post_extensions() {
  add_meta_box('extensions_header_meta',__('Header Image'),'render_image_box','post','side','high');
}

function extensions_save_meta_box_data( $post_id ) {

	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['extensions_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['extensions_meta_box_nonce'], 'extensions_meta_box' ) ) {
		return;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

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

  	// Sanitize user input.
	$my_data = sanitize_text_field( $_POST['header-img'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, 'extensions_header_image', $my_data );
}

add_action('save_post', 'extensions_save_meta_box_data' );
add_action('admin_menu', 'init_post_extensions');
