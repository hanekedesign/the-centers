<?php if ($_REQUEST['__process_form'] == true) {
  if ($_REQUEST['__process_form'] == true) {
    include_once(locate_template($_REQUEST['__process_form_action']));
    die();
  }
}?>

<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php wp_title('|', true, 'right'); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="msvalidate.01" content="00489E51BC1A707C65D87F30B88AA189" /> 
  <meta name="google-site-verification" content="YseGklCTG3Xw8-0akl3SCb2KizedCjbWCiY-mZsWKiA" /> 
  <?php wp_head(); ?>

  <script type="text/javascript" src="//use.typekit.net/fny7rpa.js"></script>
  <script type="text/javascript">try{Typekit.load();}catch(e){}</script>
  <link rel="alternate" type="application/rss+xml" title="<?php echo get_bloginfo('name'); ?> Feed" href="<?php echo esc_url(get_feed_link()); ?>">
</head>
