<?php
/*
Template Name: Documents Template
*/

global $post;

function getKeyName($str) {
  return strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $str));
}

$args = array(
    'post_type' => 'attachment',
    'numberposts' => -1,
    'post_status' => null,
    'post_parent' => null, // any parent
    ); 
$attachments = get_posts($args);
$children = array();
if ($attachments) {
    foreach ($attachments as $posts) {
      $folder = get_post_meta($posts->ID, 'media_extensions_category', TRUE)?:null;
      if ($folder == null || in_array($folder, $children)) continue;
      $children[] = $folder;
    }
}
?>

<div class="container">
  <?php foreach ($children as $child) : ?>
    <div class="row">
      <div class="col-xs-12">
        <div class="document-col">
          <div class="row document-row">
            <div class="col-sm-12">
              <div class="document-box">
                <h2 class="heading"><?php echo $child; ?></h2>
                <p><?php echo get_post_meta($post->ID, 'advedt_files_folder_desc_'.getKeyName($child), TRUE)?:"No description"; ?> </p>
                <a class="button" href="<?php echo get_post_meta($post->ID, 'advedt_files_folder_link_'.getKeyName($child), TRUE)?:"#"; ?>">View Documents</a>
              </div>
            </div>  
          </div>
        </div>
      </div>
    </div>
  <?php endforeach ?>
</div>