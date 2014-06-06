<?php
require_once('wp-load.php'); 
$location = $_REQUEST['redirect_target']?:substr($_SERVER['HTTP_REFERER'],0,strrpos($_SERVER['HTTP_REFERER'],'?'));

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

wp_mail(get_option('forms_email',"webmaster@localhost"), "Form Submission from 'The Centers' website.",$email);

wp_redirect( $location . "?from-form=true");
die();
?>