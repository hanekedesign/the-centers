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
        <select id="news-archive">
          <?php 
            $args = array(
              'type'            => 'monthly',
              'limit'           => '1',
              'format'          => 'custom', 
              'before'          => '<option selected disabled style="display: none;">',
              'after'           => '</option>',
              'show_post_count' => false,
              'echo'            => 1,
              'order'           => 'DESC');            
            wp_get_archives( $args );
            $args = array(
              'type'            => 'monthly',
              'limit'           => '',
              'format'          => 'option', 
              'show_post_count' => false,
              'echo'            => 1,
              'order'           => 'DESC');  
            wp_get_archives( $args );
          ?>
        </select>
      </div>
