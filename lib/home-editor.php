<?php
function home_meta() {
  global $post;
  if (!current_user_can('manage_options'))  {
    wp_die( __('You do not have sufficient permissions to access this page.') );
  }
  
  wp_nonce_field( 'home_meta', 'home_meta_nonce' );

?>
<input type="hidden" name="post_update_file" value="home-editor-save.php">

<div class="wrap home-box">
  <p><strong>Header Banners</strong></p> 
  <div class="wp-container">
    <div class="wp-row">
      <?php create_large_editor(0); ?>
      <?php create_large_editor(1); ?>
      <?php create_large_editor(2); ?>
    </div>
  </div>
  <p><strong>Below Banners Text</strong></p> 
  <div class="wp-container">  
    <div class="wp-row">
      <div class="wp-col-12">
        <textarea name="home_largebox_header_text"><?php echo get_post_meta($post->ID, 'home_largebox_header_text', TRUE)?:"" ?></textarea>
        <p>Link Text</p>
        <input type="text" name="home_largebox_header_link_text" value="<?php echo get_post_meta($post->ID, 'home_largebox_header_link_text', TRUE)?:"" ?>">
        <p>Link Location</p>
        <input type="text" name="home_largebox_header_link" value="<?php echo get_post_meta($post->ID, 'home_largebox_header_link', TRUE)?:"" ?>">
      </div>
    </div>
  </div>
  <p><strong>Miniboxes</strong></p> 
  <div class="wp-container">  
    <div class="wp-row">
      <?php create_mini_editor(0); ?>
      <?php create_mini_editor(1); ?>
      <?php create_mini_editor(2); ?>
      <?php create_mini_editor(3); ?>
    </div>
  </div>
  <p><strong>Bottom Text</strong></p> 
  <div class="wp-container">  
    <div class="wp-row">
      <div class="wp-col-6">
        <p>Header</p>
        <input type="text" name="home_footer_header" value="<?php echo get_post_meta($post->ID, 'home_footer_header', TRUE)?:"" ?>">
        <p>Content</p>
        <textarea name="home_footer_content"><?php echo get_post_meta($post->ID, 'home_footer_content', TRUE)?:"" ?></textarea>
        <p>Button Text</p>
        <input type="text" name="home_footer_button_text" value="<?php echo get_post_meta($post->ID, 'home_footer_button_text', TRUE)?:"" ?>">
        <p>Button Link</p>
        <input type="text" name="home_footer_button_link" value="<?php echo get_post_meta($post->ID, 'home_footer_button_link', TRUE)?:"" ?>">
      </div>
      <?php $image = wp_get_attachment_image_src( get_post_meta($post->ID, 'home_footer_image', TRUE)?:0 , 'full' )?:Array(); ?>
      <div class="wp-col-6 imgsel" style="background-image: url(<?php echo $image[0]; ?>)">
        <input type="hidden" name="home_footer_image"  value="<?php echo get_post_meta($post->ID, 'home_footer_image', TRUE)?:0; ?>">
      </div>
    </div>
  </div>
</div>


<?php
}

function create_mini_editor($id) {
  global $post;
  
  $header = get_post_meta($post->ID, 'home_minibox_header_'.$id, TRUE)?:"";
  $text = get_post_meta($post->ID, 'home_minibox_text_'.$id, TRUE)?:"";
  $link = get_post_meta($post->ID, 'home_minibox_link_'.$id, TRUE)?:"";
  $link_text = get_post_meta($post->ID, 'home_minibox_link_text_'.$id, TRUE)?:"";
  $color = get_post_meta($post->ID, 'home_minibox_color_'.$id, TRUE)?:"";
  ?>
      <div class="wp-col-3">
        <div class="small-box-editor">
          <div class="color-selector">
            <select data-field="#minibox-color-<?php echo $id; ?>" data-title="Theme" name="home_minibox_color_<?php echo $id; ?>">
              <option value="primary" data-color="rgb(245,192,65)" <?php echo ($color=="primary")?"selected":""; ?>>Primary</option>
              <option value="secondary" data-color="rgb(111,193,228)" <?php echo ($color=="secondary")?"selected":""; ?>>Secondary</option>
              <option value="tertiary" data-color="rgb(155,199,100)" <?php echo ($color=="tertiary")?"selected":""; ?>>Tertiary</option>
              <option value="gray" data-color="rgb(191,191,191)" <?php echo ($color=="gray")?"selected":""; ?>>Gray</option>
            </select>          
            <div class="color-box" style="background-color: rgb(155, 199, 100);"></div>
            <input type="hidden" id="minibox-color-<?php echo $id; ?>" name="minibox-color-<?php echo $id; ?>" value="tertiary">
            <input type="text" placeholder="Mini Header" class="header" name="home_minibox_header_<?php echo $id; ?>" value="<?php echo $header; ?>">
            <input type="text" placeholder="Content" class="subheader" name="home_minibox_text_<?php echo $id; ?>" value="<?php echo $text; ?>">            
            <input type="text" placeholder="Link Text" class="subheader" name="home_minibox_link_text_<?php echo $id; ?>" value="<?php echo $link_text; ?>">
            <input type="text" placeholder="Link Location" class="subheader" name="home_minibox_link_<?php echo $id; ?>" value="<?php echo $link; ?>">            
          </div>
        </div>
      </div>
  <?php
}

function create_large_editor($id) {
  global $post;
  
  $header = get_post_meta($post->ID, 'home_largebox_header_'.$id, TRUE)?:"";
  $lineone = get_post_meta($post->ID, 'home_largebox_subheader_first_'.$id, TRUE)?:"";
  $linetwo = get_post_meta($post->ID, 'home_largebox_subheader_second_'.$id, TRUE)?:"";
  $image = get_post_meta($post->ID, 'home_largebox_header_image_'.$id, TRUE)?:0;
  $imgsrc = wp_get_attachment_image_src( $image , 'full' )?:array("");
  ?>
      <div class="wp-col-4">
        <div class="large-box-editor">
          <div class="imgsel image" style="background-image: url(<?php echo $imgsrc[0]; ?>)">
            <input name="home_largebox_header_image_<?php echo $id; ?>" type="hidden" value="<?php echo $image; ?>">
          </div>
          <div class="body">
            <input type="text" placeholder="Line 1" class="header" name="home_largebox_header_<?php echo $id; ?>" value="<?php echo $header; ?>">
            <input type="text" placeholder="Line 2" class="subheader" name="home_largebox_subheader_first_<?php echo $id; ?>" value="<?php echo $lineone; ?>">            
            <input type="text" placeholder="Line 3" class="subheader" name="home_largebox_subheader_second_<?php echo $id; ?>" value="<?php echo $linetwo; ?>">            
          </div>
          <div class="footer item_<?php echo $id; ?>">
          </div>
        </div>
      </div>
  <?php
}

remove_post_type_support('page', 'editor');
remove_post_type_support('page', 'title');
add_meta_box("home_meta", "Home Page", "home_meta", "page", "normal", "high");
?>