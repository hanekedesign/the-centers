<?php
/** Step 2 (from text above). */
add_action( 'admin_menu', 'global_menu' );

/** Step 1. */
function global_menu() {
	add_options_page( 'Global Site Options', 'Global Site Options', 'manage_options', 'centers-global-settings', 'global_options' );
  	add_action( 'admin_init', 'register_global_settings' );
}

function register_global_settings() {
	//register our settings
	register_setting( 'global-settings-group', 'phone_number' );
	register_setting( 'global-settings-group', 'forms_email' );
}

/** Step 3. */
function global_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    ?>
      <div class="wrap">
        <h2>Global Settings</h2>
        <form method="post" action="options.php"> 
        <?php settings_fields( 'global-settings-group' ); ?>
        <?php do_settings_sections( 'global-settings-group' ); ?>
        <table class="form-table">
        <tbody>
          <tr>
            <th scope="row"><label for="blogname">Phone Number</label></th>
            <td><input name="phone_number" type="text" id="phone_number" value="<?php echo get_option('phone_number',"(888) 888-8888"); ?>" class="regular-text"></td>
          </tr>
          <tr>
            <th scope="row"><label for="blogname">E-mail Settings</label></th>
            <td>
              <input name="forms_email" type="text" id="forms_email" value="<?php echo get_option('forms_email',""); ?>" class="regular-text">
              <p class="description">E-mail address that forms will get submitted to.</p>
            </td>
          </tr>
        </tbody></table>
        <?php submit_button(); ?>
        </form>
      </div>
    <?php
}
?>