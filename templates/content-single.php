<?php while (have_posts()) : the_post(); ?>
<div class="subbanner post-banner color secondary">
  <div class="container color">              
    <div class="row">
      <div class="col-sm-8 blog-items">
        <h1><?php echo get_the_title(); ?></h1>
        <div class="category">
          <?php the_category( ", " ); ?> 
        </div>
        <div class="date"><?php echo get_the_date('m.d.Y'); ?></div>
      </div>
    </div>
  </div>
</div>


<?php
  $image = wp_get_attachment_image_src( get_post_meta($post->ID, 'extensions_header_image', TRUE)?:0 , 'full' )?:Array();
?>
      
<div class="container">
  <div class="row">
    <div class="col-sm-8 blog-items">
      <div class="item">
        <div class="blog-image" style="background-image: url('<?php echo $image[0]; ?>'); height: <?php echo $image[2]; ?>px"></div>
        <div class="content post"><?php the_content(); ?></div>      
        <?php echo do_shortcode('[social type="large"]'); ?>
        <?php comments_template('/templates/comments.php'); ?>
      </div>
      <div class="nav-previous alignleft"><?php previous_post_link( '%link', '<button class="btn btn-default">Previous</button>' ); ?></div>
      <div class="nav-next alignright"><?php next_post_link(  '%link', '<button class="btn btn-default">Next</button>' ); ?></div>
    </div>
    <div class="col-sm-4">
      <?php locate_template('/templates/blog-sidebar.php', true, false); ?>
     </div>
  </div>
</div>
<?php endwhile; ?>
