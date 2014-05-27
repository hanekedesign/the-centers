<?php     
  function generate_form() {
    global $post;
    $sidebar_types = get_post_meta( $post->ID, 'advedit_sidebar_form_type', true )?:[];
    $sidebar_texts = get_post_meta( $post->ID, 'advedit_sidebar_form_text', true )?:[];
    $sidebar_names = get_post_meta( $post->ID, 'advedit_sidebar_form_name', true )?:[];
    $sidebar_place = get_post_meta( $post->ID, 'advedit_sidebar_form_placeholder', true )?:[];
    $sidebar_value = get_post_meta( $post->ID, 'advedit_sidebar_form_value', true )?:[];

    for ($i = 0; $i < count($sidebar_types); $i++) {
      switch ($sidebar_types[$i]) {
        case 'header':        
          echo '<h3>' . $sidebar_texts[$i] . '</h3>';
          break;
        case 'subheader':        
          echo '<p>' . $sidebar_texts[$i] . '</p>';
          break;
        case 'text':        
          echo '<input type="text" name="' . $sidebar_names[$i] . '" placeholder="' . $sidebar_place[$i] . '" value="' . $sidebar_texts[$i] . '">';
          break;
        case 'textarea':        
          echo '<textarea name="' . $sidebar_names[$i] . '" placeholder="' . $sidebar_place[$i] . '">' . $sidebar_texts[$i] . '</textarea>';
          break;
        case 'button':
          echo '<button type="submit" class="btn btn-default">' . $sidebar_texts[$i] . '</button><div class="cf"></div>';
          break;
      }
    }
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
        $sidebar_image = get_post_meta( $post->ID, 'advedit_sidebar_image', true );
        ?>
        <aside class="col-sm-4" role="complementary">
          <div class="photo-sidebar">
            <div class="blurb"><?php echo $blurb; ?></div>
            <div class="photo" style="background-image: url(<?php echo wp_get_attachment_image_src( $sidebar_image , 'full' )[0]; ?>)"></div>
          </div>
        </aside>
        <?php
        break; 
      case 2:
        $header = get_post_meta( $post->ID, 'advedit_sidebar_form_header', true)?:"";
        $color = get_post_meta( $post->ID, 'advedit_sidebar_form_color', true)?:"";
        ?>
        <aside class="col-sm-4" role="complementary">
          <div class="contact-sidebar">
            <div class="header <?php echo $color; ?>"><?php echo $header; ?></div>
            <div class="form"><?php generate_form(); ?></div>
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
        $title = get_post_meta($post->ID, 'advedit_header_title', TRUE)?:'';
        $text = get_post_meta($post->ID, 'advedit_header_text', TRUE)?:'';
        $image = get_post_meta($post->ID, 'advedit_header_image', TRUE)?:0;
      
        ob_start();?>
              <div class="col-xs-6">
                <div class="text">
                  <h1><?php echo $title; ?></h1>
                  <p><?php echo $text; ?></p>
                </div>
              </div>
        <?php $text_content = ob_get_clean();
        ob_start();?>
              <div class="col-xs-6">
                <div class="image" style="background-image: url(<?php echo wp_get_attachment_image_src( $image , 'full' )[0]; ?>)"></div>
              </div>
        <?php $image_content = ob_get_clean(); ?>
        <div class="subbanner image-banner color gray">
          <div class="container color <?php echo $color; ?>">              
            <div class="row">
              <?php if (!isset($right_aligned)) {
                echo $text_content;
                echo $image_content;
              } else {
                echo $image_content;
                echo $text_content;
              }
               ?>
            </div>
          </div>
        </div>
        <?php
        break; 
      case 2:
        $color = get_post_meta( $post->ID, 'advedit_header_color', true )?:'primary';
        $title = get_post_meta($post->ID, 'advedit_header_title', TRUE)?:'';
        $text = get_post_meta($post->ID, 'advedit_header_text', TRUE)?:'';
        ?>
        <div class="subbanner text-banner color <?php echo $color; ?>">
          <div class="container">              
            <div class="row">
              <div class="col-xs-12">
                <div class="text">
                  <h1><?php echo $title; ?></h1>
                  <p><?php echo $text; ?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
        break;
      case 3:
        ?>
        <?php
        break;
    }
        
    return $headermode;
  }

  function generate_small_box($id) {
    global $post;
    $header = get_post_meta($post->ID, 'advedt_minibox_header_'.$id, TRUE)?:"";
    $text = get_post_meta($post->ID, 'advedt_minibox_text_'.$id, TRUE)?:"";
    $link = get_post_meta($post->ID, 'advedt_minibox_link_'.$id, TRUE)?:"";
    $link_text = get_post_meta($post->ID, 'advedt_minibox_link_text_'.$id, TRUE)?:0;
    $color = get_post_meta($post->ID, 'advedt_minibox_color_'.$id, TRUE)?:"primary";
    ?>
        <div class="col-md-3">
          <a href="<?php echo $link; ?>" class="mini-box-link"><div class="mini-box <?php echo $color; ?>"> 
            <div class="content">
              <div class="lower"><?php echo $text; ?></div>          
            </div>
            <div class="bottom">+ <?php echo $link_text; ?></div>
          </div></a>       
        </div>
    <?php
  }

  function generate_footer() {
    global $post;
    // Get our sidebar type
    $headermode = get_post_meta( $post->ID, 'advedit_footer_mode', true );

    switch ($headermode) {
      case 0:
        break;
      case 1:
        ?>
        <div class="subbanner footer-banner color gray">
          <div class="container">              
            <div class="row">
              <?php generate_small_box(0); ?>
              <?php generate_small_box(1); ?>
              <div class="col-xs-6">
                <div class="wide-box">
                  <div class="header">
                    <?php echo get_post_meta( $post->ID, 'advedt_widebox_header', true )?:""; ?>
                  </div>
                  <a href="<?php echo get_post_meta( $post->ID, 'advedt_widebox_button', true )?:""; ?>">
                    <button class="btn btn-default"><?php echo get_post_meta( $post->ID, 'advedt_widebox_button_label', true )?:""; ?></button>
                  </a>
                  <a href="<?php echo get_post_meta( $post->ID, 'advedt_widebox_button_two', true )?:""; ?>">
                    <button class="btn btn-default"><?php echo get_post_meta( $post->ID, 'advedt_widebox_button_two_label', true )?:""; ?></button>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
        break; 
      case 2:
        ?>
        <div class="subbanner footer-banner color gray">
          <div class="container">              
            <div class="row">
              <?php generate_small_box(0); ?>
              <?php generate_small_box(1); ?>
              <?php generate_small_box(2); ?>
              <?php generate_small_box(3); ?>
            </div>
          </div>
        </div>
        <?php
        break;
    }
        
    return $headermode;
  }
?>