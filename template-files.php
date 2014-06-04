<?php
/*
Template Name: File Browser Template
*/

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
      $state = get_post_meta($post->ID, 'media_extensions_folder', TRUE)?:null;
      $subbox = get_post_meta($post->ID, 'media_extensions_subfolder', TRUE)?:"";
      if ($state == null) continue;
      if (!isset($map[$state])) $map[$state] = array();
      if (!isset($map[$state][$subbox])) $map[$state][$subbox] = array();
      $post->attachment_url = wp_get_attachment_url( $post->ID );
      if (!in_array($post->ID,$map[$state][$subbox])) $map[$state][$subbox][] = $post;
    }
}

?>

<div class="container files-style">
  <div class="row">
    <div class="col-xs-12"><h2>State Pooled Trust Documents</h2></div>
  </div>
    <div class="row">
      <div class="col-xs-10">
        <?php foreach ($map as $aid => $child) : if ($aid === 'root' || $aid === '') continue;?>
          <a href="#" class="state-button" data-tab="<?php echo $aid; ?>"><?php echo $aid; ?></a>
        <?php endforeach ?>
        <div class="state-box" id="state-box">
        </div>
      </div>
    </div>
  <?php if (isset($map['root'])) { foreach ($map['root'] as $aid => $child) { ?>
    <div class="row">
      <div class="col-xs-12">
        <h2><?php echo $aid; ?></h2>
        <?php foreach ($map['root'][$aid] as $sid => $child) : $meta = get_post( $child, '', true );?>
          <a class="document" href="<?php echo wp_get_attachment_url( $child );?>"><?php echo "$meta->post_title "; ?></a>
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