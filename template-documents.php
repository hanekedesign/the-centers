<?php
/*
Template Name: Document Template
*/

function get_first_paragraph($in){
	global $post;
	
	$str = wpautop( $in );
	$str = substr( $str, 0, strpos( $str, '</p>' ) + 4 );
	$str = strip_tags($str, '<a><strong><em>');
  
	return '<p>' . $str . '</p>';
}

$post_args =  array(
  'post_parent' => $post->ID,
  'post_type'   => 'page', 
  'posts_per_page' => -1,
  'post_status' => 'publish' );
$children = get_children($post_args);

?>

<div class="container">
  <?php foreach ($children as $child) : ?>
  <?php $subpost_args =  array(
          'post_parent' => $child->ID,
          'post_type'   => 'page', 
          'posts_per_page' => 6,
          'post_status' => 'publish' );
        $subchildren = get_children($subpost_args);
        ?>
    <div class="row">
      <div class="col-xs-12">
        <div class="document-col">
          <div class="row document-row">
            <div class="col-sm-8">
              <div class="document-box">
                <h2><?php echo $child->post_title; /*print_r($child);*/?></h2>
                <p><?php echo get_first_paragraph($child->post_content) ?></p>
                <a class="button" href="<?php echo get_permalink($child->ID); ?>">View More</a>
              </div>
            </div>  
            <div class="col-sm-4">
              <div class="document-entries">
                <?php foreach ($subchildren as $subchild) : ?>
                  <a href="<?php echo get_permalink($subchild->ID); ?>"><?php echo $subchild->post_title; ?></a>
                <?php endforeach ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach ?>
</div>