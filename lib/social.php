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

function get_social_link($target) {
  switch ($target) {
    case "facebook":
      return "http://www.facebook.com/sharer.php?p[url]=".urlencode(curPageURL());
    case "googleplus":
      return "https://plus.google.com/share?url=".urlencode(curPageURL());
    case "linkedin":
      return "http://www.linkedin.com/shareArticle?url=".urlencode(curPageURL());
    case "pinterest":
      return "https://pinterest.com/pin/create/bookmarklet/?&url=".urlencode(curPageURL());
    case "tumblr":
      return "http://www.tumblr.com/share/link?url=".urlencode(curPageURL());
    case "twitter":
      return "https://twitter.com/share?url=".urlencode(curPageURL());
  }  
}

add_shortcode('social',function($attr,$content) {
  $networks = get_option('social_networks',"")?:array();
  $return = '<div class="social-bar' . ((isset($attr['type']) && $attr['type']=="large")?" large":"" ) . '">';
  foreach ($networks as $network => $null) {
    $return .= '<a class="social-icon '.$network.'" href="' . get_social_link($network) . '"></a>';  
  }
  $return .= '</div>';
  return $return;
});



function register_social_settings() {
	//register our settings
	register_setting( 'social-settings-group', 'social_networks' );
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
	?>
    <div class="wrap">
      <h2>Social Settings</h2>
      <form method="post" action="options.php"> 
      <?php settings_fields( 'social-settings-group' ); ?>
      <?php do_settings_sections( 'social-settings-group' ); ?>
      <table>
        <tr>
          <td><div style="" class="social-icon facebook"></div></td>
          <td><input type="checkbox" name="social_networks[facebook]"<?php if (array_key_exists('facebook',$networks)) echo "checked"; ?>></input>Facebook</td>
        </tr>
        <tr>
          <td><div style="" class="social-icon googleplus"></div></td>
          <td><input type="checkbox" name="social_networks[googleplus]"<?php if (array_key_exists('googleplus',$networks)) echo "checked"; ?>></input> Google+</td>
        </tr>
        <tr>
          <td><div style="" class="social-icon linkedin"></div></td>
          <td><input type="checkbox" name="social_networks[linkedin]"<?php if (array_key_exists('linkedin',$networks)) echo "checked"; ?>></input> LinkedIn</td>
        </tr>
        <tr>
          <td><div style="" class="social-icon pinterest"></div></td>
          <td><input type="checkbox" name="social_networks[pinterest]"<?php if (array_key_exists('pinterest',$networks)) echo "checked"; ?>></input> Pinterest</td>
        </tr>
        <tr>
          <td><div style="" class="social-icon tumblr"></div></td>
          <td><input type="checkbox" name="social_networks[tumblr]"<?php if (array_key_exists('tumblr',$networks)) echo "checked"; ?>></input> Tumlr</td>
        </tr>
        <tr>
          <td><div style="" class="social-icon twitter"></div></td>
          <td><input type="checkbox" name="social_networks[twitter]"<?php if (array_key_exists('twitter',$networks)) echo "checked"; ?>></input> Twitter</td>
        </tr>
      </table>
      <?php submit_button(); ?>
    </div>
    <?php
}
?>

