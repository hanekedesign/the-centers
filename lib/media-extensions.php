<?php
// Create our mapping
$args = array(
    'post_type' => 'attachment',
    'numberposts' => -1,
    'post_status' => null,
    'post_parent' => null, // any parent
    ); 
$attachments = get_posts($args);
$map = array();
if ($attachments) {
    foreach ($attachments as $post) {
      $category = get_post_meta($post->ID, 'media_extensions_category', TRUE)?:null;
      $state = get_post_meta($post->ID, 'media_extensions_folder', TRUE)?:null;
      $subbox = get_post_meta($post->ID, 'media_extensions_subfolder', TRUE)?:"";
      if ($category == null || $category == '@none@') continue;
      if (!isset($map[$category])) $map[$category] = array();
      if (!isset($map[$category][$state])) $map[$category][$state] = array();
      if (!in_array($subbox,$map[$category][$state])) $map[$category][$state][] = $subbox;
    }
}

function render_parameters_box() {
  global $post,$targets,$map;
  wp_nonce_field( 'media_extensions_meta_box', 'media_extensions_meta_box_nonce' );
  $category = get_post_meta($post->ID, 'media_extensions_category', TRUE)?:"";
  $state = get_post_meta($post->ID, 'media_extensions_folder', TRUE)?:"";
  $subbox = get_post_meta($post->ID, 'media_extensions_subfolder', TRUE)?:"";
  ?>
    <p><strong>Category (Documents Page)</strong></p>
    <select id="media-ext-category" name="media-ext-category">
      <option value="@none@" <?php if ($category==="none") { echo " selected"; }?>>Do Not Display</option>
      <option value="@new@">(Add New)</option>
      <?php foreach ($map as $item => $data) : if ($item === "root") continue; ?>
        <option value="<?php echo $item?>"<?php if ($category==$item) { echo " selected"; }?>><?php echo "$item";  ?></option>
      <?php endforeach ?>
    </select>
    <div id="category">
      <input type="text" disabled id="media-ext-category-text" name="media-ext-category-text" value="<?php echo $category; ?>">
    </div>
    <div id="dndgroup">
      <p><strong>Folder</strong></p>
      <select id="media-ext-folder" name="media-ext-folder">
        <option value="@new@">(Add New)</option>
        <option value="root" <?php if ($state==="root") { echo " selected"; }?>>Root Folder</option>
        <?php foreach ($map[$category] as $item => $data) : if ($item === "root") continue; ?>
          <option value="<?php echo $item?>"<?php if ($state==$item) { echo " selected"; }?>><?php echo "$item";  ?></option>
        <?php endforeach ?>
      </select>
      <div id="folder">
        <input type="text" disabled id="media-ext-folder-text" name="media-ext-folder-text" value="<?php echo $state; ?>">
      </div>
      <p><strong>Subfolder</strong></p>
      <select id="media-ext-subfolder" name="media-ext-subfolder">
        <option value="@new@">(Add New)</option>
        <?php foreach ($map[$category][$state] as $item) : ?>
          <option value="<?php echo $item?>"<?php if ($subbox==$item) { echo " selected"; }?>><?php echo "$item";  ?></option>
        <?php endforeach ?>
      </select>
      <div id="subfolder">
        <input type="text" disabled id="media-ext-subfolder-text" name="media-ext-subfolder-text" value="<?php echo $subbox; ?>">
      </div>
    </div>
  <script>
      var statedatamap = <?php echo( json_encode($map) ); ?>;
      var category = "<?php echo get_post_meta($post->ID, 'media_extensions_category', TRUE)?:""; ?>";
      var state = "<?php echo get_post_meta($post->ID, 'media_extensions_folder', TRUE)?:""; ?>";
      var subbox = "<?php echo get_post_meta($post->ID, 'media_extensions_subfolder', TRUE)?:""; ?>";

      _$ = jQuery;
    
      _$('#media-ext-category').change(function() {
        _$('#category').toggle(_$('#media-ext-category').val() === "@new@" && !_$('#media-ext-category').prop('disabled'));
        _$('#media-ext-category-text').prop('disabled',_$('#media-ext-category').val() != "@new@");        
        _$('#dndgroup').toggle(_$('#media-ext-category').val() !== "@none@");  
        
        var fmap = statedatamap[_$('#media-ext-category').val()];
        _$('#media-ext-folder').html("");
        _$('#media-ext-folder').append('<option value="@new@">(Add New)</option>');          
        _$('#media-ext-folder').append('<option value="root" '+(state==="root"?" selected":"")+'>Top Level Document</option>');          
        for (item in fmap) {
          var isitem = item === state;
          if (item == "root") continue;
          _$('#media-ext-folder').append('<option value="'+ item + '"' + (isitem?" selected":"") + '>' + item + '</option>');          
        };
        _$('#media-ext-folder').change();        
      }); 
    
      _$('#media-ext-folder').change(function() {
        _$('#folder').toggle(_$('#media-ext-folder').val() === "@new@" && !_$('#media-ext-folder').prop('disabled'));
        _$('#media-ext-folder-text').prop('disabled',_$('#media-ext-folder').val() != "@new@");        

        if (_$('#media-ext-folder').val() === "") {
          _$('#media-ext-subfolder').prop('disabled',true);
        } else {
          _$('#media-ext-subfolder').prop('disabled',false);        
        }
        
        var map;
        
        if (_$('#media-ext-category').val() == "@new@") {
          map = [];
        } else {
          map = statedatamap[_$('#media-ext-category').val()][_$('#media-ext-folder').val()];
        }
        
        _$('#media-ext-subfolder').html("");
        _$('#media-ext-subfolder').append('<option value="@new@">(Add New)</option>');          
        for (item in map) {
          var isitem = map[item] === subbox;
          _$('#media-ext-subfolder').append('<option value="'+ map[item] + '"' + (isitem?" selected":"") + '>' + map[item] + '</option>');          
        };
        _$('#media-ext-subfolder').change();
      }); 
    
      _$('#media-ext-subfolder').change(function() {
        _$('#subfolder').toggle(_$('#media-ext-subfolder').val() === "@new@" && !_$('#media-ext-subfolder').prop('disabled'));
        _$('#media-ext-subfolder-text').prop('disabled',_$('#media-ext-subfolder').val() != "@new@");        
      }); 
    
      _$('#media-ext-category').change();
  </script>
<?php
}

function init_media_extensions() {
  add_meta_box('media_extensions_header_meta',__('File Sorting'),'render_parameters_box','attachment','side','high');
}

function media_extensions_save_meta_box_data( $post_id ) {
	/*
	 * We need to verify this came from our screen and with proper authorization,
	 * because the save_post action can be triggered at other times.
	 */

	// Check if our nonce is set.
	if ( ! isset( $_POST['media_extensions_meta_box_nonce'] ) ) {
		return;
	}

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['media_extensions_meta_box_nonce'], 'media_extensions_meta_box' ) ) {
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

	// Update the meta field in the database.
    if ($_POST['media-ext-category'] == "@none@") {
      update_post_meta( $post_id, 'media_extensions_folder', "@none@" );
      update_post_meta( $post_id, 'media_extensions_category', "" );
      update_post_meta( $post_id, 'media_extensions_subfolder', "" );
    } else {
      if ($_POST['media-ext-category'] == "@new@") {
        update_post_meta( $post_id, 'media_extensions_category', $_POST['media-ext-category-text'] );
      } else {
        update_post_meta( $post_id, 'media_extensions_category', $_POST['media-ext-category'] );
      }

      if ($_POST['media-ext-folder'] == "@new@") {
        update_post_meta( $post_id, 'media_extensions_folder', $_POST['media-ext-folder-text'] );
      } else {
        update_post_meta( $post_id, 'media_extensions_folder', $_POST['media-ext-folder'] );
      }

      if ($_POST['media-ext-subfolder'] == "@new@") {
        update_post_meta( $post_id, 'media_extensions_subfolder', $_POST['media-ext-subfolder-text'] );
      } else {
        update_post_meta( $post_id, 'media_extensions_subfolder', $_POST['media-ext-subfolder'] );
      }
    }
}

add_action('edit_attachment', 'media_extensions_save_meta_box_data' );
add_action('admin_menu', 'init_media_extensions');
