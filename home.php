<?php
  $ppp = get_option('posts_per_page');
  if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
  elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
  else { $paged = 1; }
  query_posts('posts_per_page=' . $ppp . '&paged=' . $paged); 
?>
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
        <div class="title"><?php echo get_the_title(); ?></div>
        <div class="category">
          <?php foreach (get_the_category() as $category) : ?>
            <a href="<?php echo get_category_link($category->term_id); ?>"><?php echo $category->name; ?></a>
          <?php endforeach ?>
        </div>
        <div class="date"><?php echo get_the_date('m.d.Y'); ?></div>
        <div class="excerpt"><?php echo get_the_excerpt(); ?></div>      
        <a href="<?php echo get_permalink(); ?>" class="link">Read More</a>  
        <hr>
      </div>
      <?php endwhile; ?>
      <div class="nav-previous alignleft"><?php next_posts_link( '<button class="btn btn-default">Previous</button>' ); ?></div>
      <div class="nav-next alignright"><?php previous_posts_link( '<button class="btn btn-default">Next</button>' ); ?></div>
    </div>
    <div class="col-sm-4">
      <div class="sidebar-categories sidebar-box">
        <div class="title">Categories</div>
          <?php 
            $args = array(
              'type'                     => 'post',
              'child_of'                 => 0,
              'parent'                   => '',
              'orderby'                  => 'name',
              'order'                    => 'ASC',
              'hide_empty'               => 1,
              'hierarchical'             => 1,
              'exclude'                  => '',
              'include'                  => '',
              'number'                   => '',
              'taxonomy'                 => 'category',
              'pad_counts'               => false); 
            $categories = get_categories ( $args );
            foreach ($categories as $category) {
              ?> <a href="<?php echo esc_url(get_category_link($category->cat_ID)); ?>"><?php echo($category->name); ?></a> <?php
            }
          ?>
      </div>      
      <?php get_search_form(); ?>
      <form class="newsletter sidebar-box">
        <label for="male">Sign Up for Our Newsletter</label><br>
        <input type="email" name="email" id="email" placeholder="Your email address"><br>
        <button type="submit" value="Submit">Sign up</button>
      </form>
      <div class="sidebar-box">
        <div class="title">News Archive</div>
        <select>
          <?php 
            $args = array(
              'type'            => 'monthly',
              'limit'           => '',
              'format'          => 'option', 
              'before'          => '',
              'after'           => '',
              'show_post_count' => false,
              'echo'            => 1,
              'order'           => 'DESC');
            wp_get_archives( $args );
          ?>
        </select>
      </div>
    </div>
  </div>
</div>

