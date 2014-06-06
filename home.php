<?php         
  $title = get_post_meta(get_option('page_for_posts'), 'advedit_header_title', TRUE)?:'';
  $text = get_post_meta(get_option('page_for_posts'), 'advedit_header_text', TRUE)?:''; 
?>

<div class="subbanner post-banner color secondary">
  <div class="container color">              
    <div class="row">
      <div class="col-sm-8 blog-items">
        <h1><?php echo $title; ?></h1>
        <p><?php echo $text; ?></p>
      </div>
    </div>
  </div>
</div>

<?php include_once('archive.php'); ?>