<header class="container banner">
  <div class="content row">
    <div class="col-xs-12"><!-- TODO: XS - this might change to a two-line setup -->
      <a href="/"><div class="img"></div></a>
      <div class="callbox">
        <p class="cta">Call Us</p>
        <a class="number" href="tel:<?php echo preg_replace("/[^0-9]/","",get_option('phone_number',"(888) 888-8888")); ?>"><?php echo get_option('phone_number',"(888) 888-8888"); ?></a>
      </div>
      <nav class="nav-mini">
          <?php
            if (has_nav_menu('primary_mini_nav')) :
              wp_nav_menu(array('theme_location' => 'primary_mini_nav', 'menu_class' => 'nav nav-mini'));
            endif;
          ?>
      </nav>
    </div>
  </div>
</header>

<?php
function new_nav_menu_items($items) {
    $homelink = '<li class="sm-only"><a href="' . home_url( '/about' ) . '">' . __('About Us') . '</a></li>';
    // add the home link to the end of the menu
    $items = $items . $homelink;
    return $items;
}
add_filter( 'wp_nav_menu_items', 'new_nav_menu_items' );
?>

<nav class="nav-main" role="navigation">
  <div class="container">
    <div class="content row">
      <div class="col-xs-12 nav-justify">
        <?php
          if (has_nav_menu('primary_navigation')) :
            wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav nav-blocks'));
          endif;          
        ?>
      </div>
    </div>
  </div>
</nav>


<?php
remove_filter( 'wp_nav_menu_items', 'new_nav_menu_items' );
?>

<?php
  if (is_page() || is_home() || is_single()) {
    include_once locate_template('/lib/advance-edit-toolkit.php');
    generate_header();
  }
?>

<?php
  $sidebar_siblm = get_post_meta( $post->ID, 'advedit_sidebar_sibling_menu', true )?:false;
  $sidetra = "";

  if ($sidebar_siblm) {
    // Get 2nd level ID.
    $tgt_post = $post;

    while (get_post(get_post($tgt_post->ID)->post_parent)->post_parent != 0) {
      $tgt_post = get_post($tgt_post->post_parent);
    }

    $parent = get_post($tgt_post->post_parent);
    $post_args =  array(
      'post_parent' => $tgt_post->ID,
      'post_type'   => 'page', 
      'posts_per_page' => -1,
      'post_status' => 'publish' );
    $children = get_children($post_args);
    ?>
        <div class="sidebar-menu visible-xs">
          <div data-toggle="collapse" data-target="#test" class="header expand"><?php echo $parent->post_title; ?></div>
          <div id="test" class="collapse">
            <a href="<?php echo get_permalink($tgt_post->ID); ?>" class="subheader active"><?php echo $tgt_post->post_title; ?></a>
            <?php foreach ($children as $child) { ?>
            <a href="<?php echo get_permalink($child->ID); ?>" class="entry<?php echo ($child->ID == $post->ID)?" active":""?>"><?php echo $child->post_title; ?></a>
            <?php } ?>
          </div>
        </div>
<?php } ?>
