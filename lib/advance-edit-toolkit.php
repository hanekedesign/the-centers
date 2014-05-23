<?php 
  function atk_gf_header($params,$body) {
    return "<h3>" . do_shortcode($body) . "</h3>";
  }

  function atk_gf_text($params,$body) {
    return "<p>" . do_shortcode($body) . "</p>";
  }

  function atk_gf_textbox($params,$body) {
    return '<input type="text" name="' . $params['name'] . '" placeholder="' . $params['placeholder'] . '" value="' . do_shortcode($body) . '">';
  }

  function atk_gf_textarea($params,$body) {
    return '<textarea name="' . $params['name'] . '" placeholder="' . $params['placeholder'] . '">' . do_shortcode($body) . '</textarea>';
  }

  function atk_gf_submit($params,$body) {
    return '<button type="submit" class="btn btn-default">' . $body . '</button><div class="cf"></div>';
  }

  function generate_form() {
    $val = getGlobalOption('contact_form');
    add_shortcode("header",'atk_gf_header');
    add_shortcode("text",'atk_gf_text');
    add_shortcode("textbox",'atk_gf_textbox');
    add_shortcode("textarea",'atk_gf_textarea');
    add_shortcode("submit",'atk_gf_submit');
    $processed = do_shortcode($val);
    remove_shortcode("header");
    remove_shortcode("text");
    remove_shortcode("textbox");
    remove_shortcode("textarea");
    remove_shortcode("submit");
    return $processed;
  }

  function get_panel_mode() {
    global $post;
    return get_post_meta( $post->ID, 'advedit_panelmode', true );
  }

  function generate_panel() {
    global $post;
    // Get our sidebar type
    $panelmode = get_post_meta( $post->ID, 'advedit_panelmode', true );

    switch ($panelmode) {
      case 0:
        break;
      case 1:
        $blurb = get_post_meta( $post->ID, 'advedit_image_blurb', true );
        ?>
        <aside class="col-sm-4" role="complementary">
          <div class="photo-sidebar">
            <div class="blurb"><?php echo $blurb; ?></div>
            <div class="photo"></div>
          </div>
        </aside>
        <?php
        break; 
      case 2:
        ?>
        <aside class="col-sm-4" role="complementary">
          <div class="contact-sidebar">
            <div class="header"><?php echo getGlobalOption('contact_header'); ?></div>
            <div class="form"><?php echo generate_form(); ?></div>
          </div>
        </aside>
        <?php
        break;
      case 3:
        ?>
        <aside class="sidebar <?php echo roots_sidebar_class(); ?>" role="complementary">
          <?php include roots_sidebar_path(); ?>
        </aside>
        <?php
        break;
    }
        
    return $panelmode;
  }

  function generate_header() {
    global $post;
    // Get our sidebar type
    $headermode = get_post_meta( $post->ID, 'advedit_header_mode', true );

    switch ($headermode) {
      case 0:
        break;
      case 1:
        $color = get_post_meta( $post->ID, 'advedit_header_color', true )?:'primary';        
        ?>
        <div class="subbanner image-banner color gray">
          <div class="container color <?php echo $color; ?>">              
            <div class="row">
              <div class="col-xs-6">
                <div class="text">
                  <h1>test</h1>
                  <p>Hello World</p>
                </div>
              </div>
              <div class="col-xs-6">
                <div class="image"></div>
              </div>
            </div>
          </div>
        </div>
        <?php
        break; 
      case 2:
        ?>
        <div class="subbanner text-banner gray <?php echo $color; ?>">
          <div class="row">
            <div class="col-xs-6">
              Hello Worlds
            </div>
            <div class="col-xs-6">
              Hello Worlds
            </div>
          </div>
        </div>

        <div class="subbanner image-banner container ">
          Hello Worlds
        </div>
        break;
      case 3:
        ?>
        <?php
        break;
    }
        
    return $headermode;
  }
?>