<?php
require_once('wp-load.php'); 
$stripped = substr($_SERVER['HTTP_REFERER'],0,strrpos($_SERVER['HTTP_REFERER'],'?'));
$location = $_REQUEST['redirect_target']?:$stripped?:$_SERVER['HTTP_REFERER'];

$date = time() - base_convert($_REQUEST['pzz35f2'],15,10)/1000;

if (isset($_REQUEST['n8a8hspv']) || !isset($_REQUEST['pzz35f2']) || $date > 5000) {
  echo 'SUCCESS';
  die();
}


add_filter( 'wp_mail_content_type', 'set_content_type' );
function set_content_type( $content_type ){
	return 'text/html';
}

$email = "<h3><strong> A form has been submitted from a form on 'The Centers'.</strong></h3>";

foreach ($_REQUEST['formerly_form'] as $key => $item) {
  $key = ucwords($key);
  $email .= "<strong>$key</strong>: $item<br>";
}

$email .= "<br/><h3><strong>Extra Data</strong></h3>";
$email .= "<strong>Referrer</strong>: ". $_SERVER['HTTP_REFERER'] ."<br>";
$email .= "<strong>Time & Date</strong>: ". date('m/d/Y h:i:s a', time()) ."<br>";

echo "<h1>The e-mail below has been generated and sent to the remote server.</h1>";

echo '<div style="background-color: rgba(230,230,230,1); padding: 10px; ">';
echo $email;
echo '</div>';

echo "<p>If you are not automatically redirected, click <a href=\"$location?from-form=true\">here.</a></p>";
echo "<sub>$location</sub>";

wp_mail(get_option('forms_email',"webmaster@localhost"), "Form Submission from 'The Centers' website.",$email);

wp_redirect( $location . "?from-form=true&res=" . $location);
die();
?>