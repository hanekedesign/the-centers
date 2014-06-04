<?php
/**
 * Roots includes
 */
require_once locate_template('/lib/utils.php');           // Utility functions
require_once locate_template('/lib/init.php');            // Initial theme setup and constants
require_once locate_template('/lib/wrapper.php');         // Theme wrapper class
require_once locate_template('/lib/sidebar.php');         // Sidebar class
require_once locate_template('/lib/config.php');          // Configuration
require_once locate_template('/lib/activation.php');      // Theme activation
require_once locate_template('/lib/titles.php');          // Page titles
require_once locate_template('/lib/cleanup.php');         // Cleanup
require_once locate_template('/lib/nav.php');             // Custom nav modifications
require_once locate_template('/lib/gallery.php');         // Custom [gallery] modifications
require_once locate_template('/lib/comments.php');        // Custom comments modifications
require_once locate_template('/lib/relative-urls.php');   // Root relative URLs
require_once locate_template('/lib/widgets.php');         // Sidebars and widgets
require_once locate_template('/lib/scripts.php');         // Scripts and stylesheets
require_once locate_template('/lib/custom.php');          // Custom functions

/* Get our DB name(s) */
$variables_table = $wpdb->prefix . "centers_data";

function core_scripts() {
  wp_enqueue_style('my-admin-theme', get_template_directory_uri() . '/assets/css/admin.min.css');
  wp_enqueue_script('advedit-js-sorty', get_template_directory_uri() . '/assets/js/advedit-sorty.js', array('jquery'));
  wp_enqueue_script('advedit-js', get_template_directory_uri() . '/assets/js/advedit.js', array('jquery','advedit-js-sorty'));
}

if (is_admin()) {
  function modify_editor() {
    global $post;
    
    if (!isset($post->ID)) return;
    
    // Our main page will be scripted      
    if ($post->ID === get_option( 'page_on_front' )) {
      require_once locate_template('/lib/home-editor.php');
    } else {
      require_once locate_template('/lib/advanced-editor.php');
    }
  }
  
  add_action('admin_enqueue_scripts', 'core_scripts');
  add_action('pre_get_posts', 'modify_editor' );
}

require_once locate_template('/lib/post-extensions.php');
require_once locate_template('/lib/media-extensions.php');
  
function get_search_form_with_label($print, $label) {
  global $searchlabel;
  $searchlabel = $label;
  get_search_form($print);
  unset($searchlabel);
}

function create_database() {
  global $wpdb, $variables_table;
  $sql = "CREATE TABLE $variables_table (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
    updated datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
    name varchar(48) NOT NULL UNIQUE,
    value text NOT NULL,
    UNIQUE KEY id (id)
  );";
  
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );
} 
add_action( 'after_switch_theme', 'create_database' );

function addGlobalOption($name,$value) {
  global $wpdb, $variables_table;
  
  $return = $wpdb->insert( $variables_table, array( 
    'created' => current_time('mysql'), 
    'updated' => current_time('mysql'),
    'name' => $name, 
    'value' => $value ) );
}

function updateGlobalOption($name,$value) {
  global $wpdb, $variables_table;
  
  $return  = $wpdb->update( $variables_table, 
    array('updated' => current_time('mysql'),
      'value' => $value ),
    array('name' => $name));
}

function addOrUpdateGlobalOption($name,$value) {
  if (!hasGlobalOption($name)) {
    addGlobalOption($name,$value);
  } else {
    updateGlobalOption($name,$value);
  }
}

function hasGlobalOption($name) {
  global $wpdb, $variables_table;  
  $query = $wpdb->prepare("SELECT * FROM $variables_table WHERE name = %s",$name);
  $result = $wpdb->get_row($query);
  return isset($result);
}

function getGlobalOptionsByPrefix($prefix) {
  global $wpdb, $variables_table;  
  $query = $wpdb->prepare("SELECT * FROM $variables_table WHERE name LIKE %s",$prefix."_%");
  $result = $wpdb->get_results($query);
  $titles = array();
  
  foreach ( $result as $result_i ) 
  {
      $titles[] = $result_i;
  }
  return $titles;
}

function getGlobalOption($name) {
  global $wpdb, $variables_table;  
  $query = $wpdb->prepare("SELECT * FROM $variables_table WHERE name = %s",$name);
  $result = $wpdb->get_row($query);
  return stripslashes(isset($result->value)?$result->value:NULL);
}

function grab_save() {
  if ( isset( $_POST['post_update_file'] ) ) { 
    require_once locate_template('/lib/'.$_POST['post_update_file']);
  }
} 
add_action('save_post', 'grab_save');

add_shortcode('subbox',function($attr,$content) {
  return '<div class="subbox">' . do_shortcode($content) . '</div>';
});
add_shortcode('header',function($attr,$content) {
  return '<h2>' . do_shortcode($content) . '</h2>';
});


