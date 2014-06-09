<?php
/*
Template Name: File Browser Template
*/

$tlc = get_post_meta($post->ID,'advedt_files_browse_category',true);
$args = array(
    'post_type' => 'attachment',
    'numberposts' => -1,
    'post_status' => null,
    'post_parent' => null, // any parent
    ); 
$attachments = get_posts($args);
$map = array();

if ($attachments) {
    foreach ($attachments as $post) {
      $category = get_post_meta($post->ID, 'media_extensions_category', TRUE)?:null;
      $state = get_post_meta($post->ID, 'media_extensions_folder', TRUE)?:null;
      $subbox = get_post_meta($post->ID, 'media_extensions_subfolder', TRUE)?:"";
      if ($tlc != "" && $tlc != $category) continue;
      if ($state == null) continue;
      if (!isset($map[$state])) $map[$state] = array();
      if (!isset($map[$state][$subbox])) $map[$state][$subbox] = array();
      $post->attachment_url = wp_get_attachment_url( $post->ID );
      if (!in_array($post->ID,$map[$state][$subbox])) $map[$state][$subbox][] = $post;
    }
}

$hit = false; 
foreach ($map as $aid => $child) : if ($aid === 'root' || $aid === '') continue; $hit = true; endforeach;


?>

<div class="container files-style">
  <div class="row">
    <div class="col-xs-12"><h2>State Pooled Trust Documents</h2></div>
  </div>
    <?php if (!$hit) { ?>
    <div class="row">
      <div class="col-xs-10">
        <?php foreach ($map as $aid => $child) : if ($aid === 'root' || $aid === '') continue; ?>
          <a href="#" class="state-button" data-tab="<?php echo $aid; ?>"><?php echo $aid; ?></a>
        <?php endforeach ?>
        <div class="state-box" id="state-box">
        </div>
      </div>
    </div>
    <?php } ?>
  <?php if (isset($map['root'])) { foreach ($map['root'] as $aid => $child) { ?>
    <div class="row">
      <div class="col-xs-12">
        <h2><?php echo $aid; ?></h2>
        <?php foreach ($map['root'][$aid] as $sid => $child) : ?>
          <a class="document" href="<?php echo $child->attachment_url ?>"><?php echo "$child->post_title "; ?></a>
        <?php endforeach ?>
      </div>
    </div>
  <?php } } ?>
</div>

<script type="application/javascript">
  data = <?php echo json_encode($map); ?>;
  _$ = jQuery;
  _$(function() {
    _$('.state-button').click(function() {
      _$('.state-button').removeClass('active');
      _$(this).addClass('active');
      _$('#state-box').html("");
      var target = _$(this).data('tab');
      for (var subdata in data[target]) {
        _$('#state-box').append('<h3>' + subdata + '</h3>');
        for (var file in data[target][subdata]) {
          _$('#state-box').append('<a class="document" href="' + data[target][subdata][file]["attachment_url"] + '">' + data[target][subdata][file]["post_title"] + '</a>');
        }
      }
      return false;
    });
    _$('.state-button').first().click();
  });
</script>