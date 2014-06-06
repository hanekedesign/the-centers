<?php
function generate_large_box($id) {
  global $post;
  $header = get_post_meta($post->ID, 'home_largebox_header_'.$id, TRUE)?:"";
  $lineone = get_post_meta($post->ID, 'home_largebox_subheader_first_'.$id, TRUE)?:"";
  $linetwo = get_post_meta($post->ID, 'home_largebox_subheader_second_'.$id, TRUE)?:"";
  $link = get_post_meta($post->ID, 'home_largebox_subheader_link_'.$id, TRUE)?:"";
  $image = get_post_meta($post->ID, 'home_largebox_header_image_'.$id, TRUE)?:0;
  $image_src = wp_get_attachment_image_src( $image , 'full' )?:Array("");
  $colors = array("secondary", "tertiary", "primary");
  $color = $colors[$id];
  ?>
      <div class="col-sm-4">
        <a href="<?php echo $link; ?>" class="no-ul">
          <div class="home-box"> 
            <div class="image" style="background-image: url(<?php echo $image_src[0]; ?>)"></div>
            <div class="content">
              <div class="upper"><?php echo $header; ?></div>
              <div class="lower"><?php echo $lineone; ?><br/><?php echo $linetwo; ?></div>          
            </div>
            <div class="bottom <?php echo $color; ?>">+ Find out how</div>
          </div>  
        </a>
      </div>
  <?php
}


?>
<div class="colored-back primary home-one">
  <div class="container">
    <div class="row">
      <?php generate_large_box(0); ?>
      <?php generate_large_box(1); ?>
      <?php generate_large_box(2); ?>
    </div>
  </div>
</div>

<div class="colored-back secondary home-two">
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <?php echo  html_entity_decode(get_post_meta($post->ID, 'home_largebox_header_text', TRUE)?:""); ?><br/>
        <a href="<?php echo get_post_meta($post->ID, 'home_largebox_header_link', TRUE)?:""; ?>">+ <?php echo get_post_meta($post->ID, 'home_largebox_header_link_text', TRUE)?:""; ?></a>
      </div>
    </div>
  </div>
</div>

<div class="colored-back white home-three">
  <div class="container">
    <div class="row">
      <?php generate_small_box("home",0); ?>
      <?php generate_small_box("home",1); ?>
      <?php generate_small_box("home",2); ?>
      <?php generate_small_box("home",3); ?>
    </div>
  </div>
</div>

<div class="colored-back primary home-four">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <div class="flow">
          <h3><?php echo get_post_meta($post->ID, 'home_footer_header', TRUE)?:""; ?></h3>
          <p><?php echo get_post_meta($post->ID, 'home_footer_content', TRUE)?:""; ?></p>
          <a href="<?php echo get_post_meta($post->ID, 'home_footer_button_link', TRUE)?:""; ?>"><button class="btn btn-default"><?php echo get_post_meta($post->ID, 'home_footer_button_text', TRUE)?:""; ?></button></a>
        </div>
      </div>
      <div class="col-md-6">
        <?php $image_url = wp_get_attachment_image_src( get_post_meta($post->ID, 'home_footer_image', TRUE)?:0 , 'full' )?:Array(""); ?>
        <div class="image" style="background-image: url(<?php echo $image_url[0]; ?>)"></div>
      </div>
    </div>
  </div>
</div>
