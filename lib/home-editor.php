<?php
function home_meta() {
  if (!current_user_can('manage_options'))  {
    wp_die( __('You do not have sufficient permissions to access this page.') );
  }
?>

<div class="wrap">
  <p><strong>Banners</strong></p> 
  <div class="imagebox-edit primary">
    <div class="footer">
    </div>
  </div>
</div>


<?php
}

remove_post_type_support('page', 'editor');
remove_post_type_support('page', 'title');
add_meta_box("home_meta", "Home Page", "home_meta", "page", "normal", "high");
?>