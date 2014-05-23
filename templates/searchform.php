<?php
global $searchlabel;
if (!isset($searchlabel)) {
  $searchtext = __('Search', 'roots') . ' ' .  get_bloginfo('name'); 
} else {
  $searchtext = $searchlabel;
}
?>
<form role="search" method="get" class="search-form form-inline" action="<?php echo home_url('/'); ?>">
  <div class="input-group">
    <input type="search" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s" class="search-field form-control" placeholder="<?php echo $searchtext; ?>">
    <label class="hide"><?php _e('Search for:', 'roots'); ?></label>
    <span class="input-group-btn">
      <button type="submit" class="search-submit glyphicon glyphicon-search"></button>
    </span>
  </div>
</form>
