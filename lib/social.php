<?php

// FB: http://www.facebook.com/sharer.php?s=100&p[url]={url}&p[images][0]={img}&p[title]={title}&p[summary]={desc}
// Twitter: https://twitter.com/share?url={url}&text={title}&via={via}&hashtags={hashtags}
// Google+: https://plus.google.com/share?url={url}
// Pinterest: https://pinterest.com/pin/create/bookmarklet/?media={img}&url={url}&is_video={is_video}&description={title}
// LinkedIn: http://www.linkedin.com/shareArticle?url={url}&title={title}
// Buffer: http://bufferapp.com/add?text={title}&url={url}
// Digg: http://digg.com/submit?url={url}&title={title}
// Tumblr: http://www.tumblr.com/share/link?url={url}&name={title}&description={desc}
// Reddit: http://reddit.com/submit?url={url}&title={title}
// StumbleUpon: http://www.stumbleupon.com/submit?url={url}&title={title}
// Delicious: https://delicious.com/save?v=5&provider={provider}&noui&jump=close&url={url}&title={title}

function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

function get_social_link($target,$method) {
  $networks = get_option('social_networks_links',"")?:array();

  if ($method == "link") {
    return $networks[$target];
  } else {
    switch ($target) {
      case "facebook":      
        return "http://www.facebook.com/sharer.php?p[url]=".get_permalink();
      case "googleplus":
        return "https://plus.google.com/share?url=".get_permalink();
      case "linkedin":
        return "http://www.linkedin.com/shareArticle?url=".get_permalink();
      case "pinterest":
        return "https://pinterest.com/pin/create/bookmarklet/?&url=".get_permalink();
      case "tumblr":
        return "http://www.tumblr.com/share/link?url=".get_permalink();
      case "twitter":
        return "https://twitter.com/share?url=".get_permalink();
    } 
  }
}

add_shortcode('social',function($attr,$content) {
  $method = (isset($attr['method']))?$attr['method']:"share";
  $type = (isset($attr['type']))?$attr['type']:"post";
  $networks_post = get_option('social_networks',"")?:array();
  $networks_home = get_option('social_networks_home',"")?:array();
  $networks = $type=="home"?$networks_home:$networks_post;
  $return = '<div class="social-bar ' . $type . '">';
  
  foreach ($networks as $network => $null) {
    $return .= '<a target="_blank" class="social-icon '.$network.'" href="' . get_social_link($network,$method) . '"></a>';  
  }
  
  $return .= '</div>';
  return $return;
});



function register_social_settings() {
	//register our settings
	register_setting( 'social-settings-group', 'social_networks' );
	register_setting( 'social-settings-group', 'social_networks_home' );
	register_setting( 'social-settings-group', 'social_networks_links' );
}

function social_scripts() {
  wp_enqueue_style('my-admin-theme', get_template_directory_uri() . '/assets/css/admin.min.css');
}

add_action('admin_enqueue_scripts', 'social_scripts');

/** Step 2 (from text above). */
add_action( 'admin_menu', 'social_menu' );

/** Step 1. */
function social_menu() {
  add_menu_page( 'Social Options', 'Social Options', 'manage_options', 'social-ops-identifier', 'social_options' );
  add_action( 'admin_init', 'register_social_settings' );
}

/** Step 3. */
function social_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
    $networks = get_option('social_networks',"")?:array();
    $networks_home = get_option('social_networks_home',"")?:array();
    $network_links = get_option('social_networks_links',"")?:array();
	?>
    <div class="wrap">
      <h2>Social Settings</h2>
      <form method="post" action="options.php"> 
      <?php settings_fields( 'social-settings-group' ); ?>
      <?php do_settings_sections( 'social-settings-group' ); ?>
      <table>
        <tr>
          <th></th>
          <th>Enabled</th>
          <th>Show in Footer</th>
          <th>Home Link</th>
        </tr>
        <tr>
          <td><div style="" class="social-icon facebook"></div></td>
          <td><input type="checkbox" name="social_networks[facebook]"<?php if (array_key_exists('facebook',$networks)) echo "checked"; ?>></input>Facebook</td>
          <td><input type="checkbox" name="social_networks_home[facebook]"<?php if (array_key_exists('facebook',$networks_home)) echo "checked"; ?>></input>Show on Footer</td>
          <td><input type="text" name="social_networks_links[facebook]" value="<?php if (array_key_exists('facebook',$network_links)) {echo $network_links['facebook'];} else {echo "http://facebook.com/[username or page name]";} ?>"></input></td>
        </tr>
        <tr>
          <td><div style="" class="social-icon googleplus"></div></td>
          <td><input type="checkbox" name="social_networks[googleplus]"<?php if (array_key_exists('googleplus',$networks)) echo "checked"; ?>></input> Google+</td>
          <td><input type="checkbox" name="social_networks_home[googleplus]"<?php if (array_key_exists('googleplus',$networks_home)) echo "checked"; ?>></input> Show on Footer</td>
          <td><input type="text" name="social_networks_links[googleplus]" value="<?php if (array_key_exists('googleplus',$network_links)) {echo $network_links['googleplus'];} else {echo "http://plus.google.com/[username or page name]";} ?>"></input></td>
        </tr>
        <tr>
          <td><div style="" class="social-icon linkedin"></div></td>
          <td><input type="checkbox" name="social_networks[linkedin]"<?php if (array_key_exists('linkedin',$networks)) echo "checked"; ?>></input> LinkedIn</td>
          <td><input type="checkbox" name="social_networks_home[linkedin]"<?php if (array_key_exists('linkedin',$networks_home)) echo "checked"; ?>></input> Show on Footer</td>
          <td><input type="text" name="social_networks_links[linkedin]" value="<?php if (array_key_exists('linkedin',$network_links)) {echo $network_links['linkedin'];} else {echo "http://linkedin.com/[username]";} ?>"></input></td>
        </tr>
        <tr>
          <td><div style="" class="social-icon pinterest"></div></td>
          <td><input type="checkbox" name="social_networks[pinterest]"<?php if (array_key_exists('pinterest',$networks)) echo "checked"; ?>></input> Pinterest</td>
          <td><input type="checkbox" name="social_networks_home[pinterest]"<?php if (array_key_exists('pinterest',$networks_home)) echo "checked"; ?>></input> Show on Footer</td>
          <td><input type="text" name="social_networks_links[pinterest]" value="<?php if (array_key_exists('pinterest',$network_links)) {echo $network_links['pinterest'];} else {echo "http://pinterest.com/[username]";} ?>"></input></td>
        </tr>
        <tr>
          <td><div style="" class="social-icon tumblr"></div></td>
          <td><input type="checkbox" name="social_networks[tumblr]"<?php if (array_key_exists('tumblr',$networks)) echo "checked"; ?>></input> Tumlr</td>
          <td><input type="checkbox" name="social_networks_home[tumblr]"<?php if (array_key_exists('tumblr',$networks_home)) echo "checked"; ?>></input> Show on Footer</td>
          <td><input type="text" name="social_networks_links[tumblr]" value="<?php if (array_key_exists('tumblr',$network_links)) {echo $network_links['tumblr'];} else {echo "http://tumblr.com/[username]";} ?>"></input></td>
        </tr>
        <tr>
          <td><div style="" class="social-icon twitter"></div></td>
          <td><input type="checkbox" name="social_networks[twitter]"<?php if (array_key_exists('twitter',$networks)) echo "checked"; ?>></input> Twitter</td>
          <td><input type="checkbox" name="social_networks_home[twitter]"<?php if (array_key_exists('twitter',$networks_home)) echo "checked"; ?>></input> Show on Footer</td>
          <td><input type="text" name="social_networks_links[twitter]" value="<?php if (array_key_exists('twitter',$network_links)) {echo $network_links['twitter'];} else {echo "http://twitter.com/[username]";} ?>"></input></td>
        </tr>        
        <tr>
          <td><div style="" class="social-icon youtube"></div></td>
          <td><input type="checkbox" disabled name="social_networks[youtube]"></input> YouTube</td>
          <td><input type="checkbox" name="social_networks_home[youtube]"<?php if (array_key_exists('youtube',$networks_home)) echo "checked"; ?>></input> Show on Footer</td>
          <td><input type="text" name="social_networks_links[youtube]" value="<?php if (array_key_exists('youtube',$network_links)) {echo $network_links['youtube'];} else {echo "http://youtube.com/[username]";} ?>"></input></td>
        </tr>
      </table>
      <?php submit_button(); ?>
    </div>
    <?php
}
?>

