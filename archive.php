<?php
function new_excerpt_more( $more ) {
  return '<a href="'. get_permalink( get_the_ID() ) . '" class="link">Read More</a>';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );
?>

<?php if (!is_home() && !is_search()) : ?>
<div class="subbanner post-banner color secondary">
  <div class="container color">              
    <div class="row">
      <div class="col-sm-8 blog-items">
        <?php if (is_month()) : ?>
        <h1>Archive for <?php the_time('F, Y'); ?></h1>
        <?php elseif (is_category()) : ?>
        <h1><?php single_cat_title(); ?></h1>
        <?php endif ?>
      </div>
    </div>
  </div>
</div>
<?php endif ?>

<div class="container">
  <div class="row">
    <div class="col-sm-8 blog-items">
      <?php while (have_posts()) : the_post(); ?>
      <div class="item">
        <div class="right">
          <div class="social"><?php echo do_shortcode('[social]'); ?></div> 
          <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail(array(130,130)); ?>
          <?php endif ?>
        </div>
        <a href="<?php the_permalink(); ?>" class="title"><?php echo get_the_title(); ?></a>
        <div class="category">
          <?php the_category(", "); ?>
        </div>
        <div class="date"><?php echo get_the_date('m.d.Y'); ?></div>
        <div class="excerpt"><?php echo get_the_excerpt(); ?></div>      
        <hr>
      </div>
      <?php endwhile; ?>
      <div class="nav-previous alignleft"><?php next_posts_link( '<button class="btn btn-default">Previous</button>' ); ?></div>
      <div class="nav-next alignright"><?php previous_posts_link( '<button class="btn btn-default">Next</button>' ); ?></div>
    </div>
    <div class="col-sm-4">
      <?php locate_template('/templates/blog-sidebar.php', true, false); ?>
     </div>
  </div>
</div>

