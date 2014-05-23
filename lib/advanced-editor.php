<?php   

function render_header_box() {
  global $post;
  
  // Allow saving
  echo '<input type="hidden" name="post_update_file" value="advanced-edit-toolkit-save-fix.php">';

  $sel_id = get_post_meta($post->ID, 'advedit_header_mode', TRUE);
  $sel_id = empty($sel_id)?0:$sel_id;
  
  $sel_color = get_post_meta($post->ID, 'advedit_header_color', TRUE)?:"primary";

  wp_nonce_field( 'advedit_meta', 'advedit_meta_nonce' );

  ?>
  <div class="wp-container inputmod">
    <div class="wp-row">
      <div class="wp-col-2">
        <div class="selectbox">
          <div data-field="#header-mode" data-group="header" data-target="#empty"     class="autotabs<?php if($sel_id==0) echo " active"?>" data-id="0">No Header</div>
          <div data-field="#header-mode" data-group="header" data-target="#imagetext" class="autotabs<?php if($sel_id==1) echo " active"?>"        data-id="1">Image &amp; Text</div>
          <div data-field="#header-mode" data-group="header" data-target="#text"      class="autotabs<?php if($sel_id==2) echo " active"?>"        data-id="2">Text Only</div>
          <div data-field="#header-mode" data-group="header" data-target="#custom"    class="autotabs<?php if($sel_id==3) echo " active"?>"        data-id="3">Custom</div>
        </div>
        <input type="hidden" id="header-mode" name="advedit_header_mode" value="<?php echo $sel_id ?>">
        <div class="color-selector">
          <select data-field="#header-color" data-title="Theme" name="theme">
            <option value="primary" data-color="rgb(245,192,65)"<?php if($sel_color=="primary") echo " selected"?>>Primary</option>
            <option value="secondary" data-color="rgb(111,193,228)"<?php if($sel_color=="secondary") echo " selected"?>>Secondary</option>
            <option value="tertiary" data-color="rgb(155,199,100)"<?php if($sel_color=="tertiary") echo " selected"?>>Tertiary</option>
            <option value="gray" data-color="rgb(191,191,191)"<?php if($sel_color=="gray") echo " selected"?>>Gray</option>
          </select>          
          <div class="color-box"></div>
          <input type="hidden" id="header-color" name="advedit_header_color" value="<?php echo $sel_id ?>">
        </div>
      </div>
      <div id="empty" class="editor">
        <div class="wp-col-10">
          <p>This setting has no configurable options.</p>
        </div>
      </div>
      <div id="imagetext" class="editor">
        <div class="wp-col-4">
          <p><strong>Image</strong></p>
          <p>This header has no configurable options.</p>
        </div>
        <div class="wp-col-6">
          <p><strong>Text</strong></p>
          <input type="text" placeholder="Header"><br/>
          <textarea placeholder="Content"></textarea>
        </div>
      </div>
      <div id="text" class="editor">
        <div class="wp-col-10">
          <p><strong>Text</strong></p>
          <input type="text" placeholder="Header"><br/>
          <textarea placeholder="Content"></textarea>
        </div>
      </div>
      <div id="custom" class="editor">
        <div class="wp-col-10">
          <?php wp_editor('', 'custom-head', array('mode' => 'specific_textareas','editor_selector' => 'tinymce-textarea')); ?>
        </div>
      </div>
    </div>  
  </div>      
  <?php
}

function render_advanced_box($leftaligned) {
  global $post;
  
  $pagetype = -1;
  
  $template_file = get_post_meta($post->ID, '_wp_page_template', TRUE);
  if ($template_file === 'template-left-align.php') {
    $pagetype = 1;
  } else if ($template_file === 'template-right-align.php') {
    $pagetype = 2;
  } else {
    $pagetype = 0;
  }
  
  if (!current_user_can('manage_options'))  {
    wp_die( __('You do not have sufficient permissions to access this page.') );
  }
  ?>
  <div class="wp-container">
    <div class="wp-row">    
      <?php 
        if ($pagetype === 1) {
          render_sidebar('3');
          render_editor('9');
        } else if ($pagetype === 2) {
          render_editor('9');
          render_sidebar('3');
        } else {
          render_editor('12');
        }
      ?>
    </div>
  </div>
<?php
} 

function render_sidebar($col) {
  global $post;
  $panelmode = get_post_meta( $post->ID, 'advedit_panelmode', true );
  
  // Image Mode Stuff
  $image_blurb = get_post_meta( $post->ID, 'advedit_image_blurb', true );

  $sidebar_types = get_post_meta( $post->ID, 'advedit_sidebar_form_type', true )?:[];
  $sidebar_texts = get_post_meta( $post->ID, 'advedit_sidebar_form_text', true )?:[];
  $sidebar_names = get_post_meta( $post->ID, 'advedit_sidebar_form_name', true )?:[];
  $sidebar_place = get_post_meta( $post->ID, 'advedit_sidebar_form_placeholder', true )?:[];
  $sidebar_value = get_post_meta( $post->ID, 'advedit_sidebar_form_value', true )?:[];

  ?>    
      <div class="wp-col-<?php echo $col; ?> meta-box-sortables ui-sortable">
        <div class="postbox">
          <h4 class="hndle_"><span>Sidebar</span></h4>
          <div class="inside">
            <p><strong>Panel Type</strong></p>
            <select name="adved_panelselect" id="adved_panelselect">
              <option value="0"<?php if ($panelmode==0) echo " selected";?>>(No Sidebar)</option>
              <option value="1"<?php if ($panelmode==1) echo " selected";?>>Photo + Text</option>
              <option value="2"<?php if ($panelmode==2) echo " selected";?>>Contact Form</option>
              <option value="3"<?php if ($panelmode==3) echo " selected";?>>Widget</option>
            </select>            
            <div class="sidebar-ops" data-id="0">
              <p><strong>Panel Configuration</strong></p>
              <p>This panel does not contain any configurable options.</p>
            </div>
            <div class="sidebar-ops" data-id="1">
              <p><strong>Photo</strong></p>
              <p><strong>Text</strong></p>
              <textarea name="advedit_image_blurb"><?php echo $image_blurb; ?></textarea>
            </div>    
            <div class="sidebar-ops" data-id="2">
              <p>Changes here apply to all pages that use the Contact Form sidebar.</p>
              <p><strong>Header Text</strong></p>
              <input type="text" name="advedit_contact_header" id="advedit_contact_header" value="<?php echo getGlobalOption('contact_header'); ?>">
              <p>
                <strong>Form Markup</strong></p>
                <sl:sortylist id="shorty" class="standard" data-form='["sidebar_form_type","sidebar_form_text","sidebar_form_name","sidebar_form_placeholder","sidebar_form_value"]' data-default='["text","Hello World","sidebar_form_name","sidebar_form_placeholder","sidebar_form_value"]' data-select="single" data-default-label="Text: Hello World!">
                  <?php 
                    for ($i = 0; $i < count($sidebar_types); $i++) {
                      ?>
                        <sl:item>
                          <?php echo ucfirst($sidebar_types[$i]?:"text"); ?>: <?php echo $sidebar_texts[$i]?:"Hello World!"; ?>
                          <input type="hidden" name="sidebar_form_type[]" value="<?php echo $sidebar_types[$i]?:"text"; ?>"/>
                          <input type="hidden" name="sidebar_form_text[]" value="<?php echo $sidebar_texts[$i]?:"Hello World!"; ?>"/>
                          <input type="hidden" name="sidebar_form_name[]" value="<?php echo $sidebar_names[$i]?:""; ?>"/>
                          <input type="hidden" name="sidebar_form_placeholder[]" value="<?php echo $sidebar_place[$i]?:""; ?>"/>
                          <input type="hidden" name="sidebar_form_value[]" value="<?php echo $sidebar_value[$i]?:""; ?>"/>
                        </sl:item>
                      <?php
                    }
                  ?>
                  <sl:controls>
                    <sl:add>Add</sl:add>
                    <sl:sub>Delete</sl:sub>
                  </sl:controls>
                </sl:sortylist>
              <div id="item-editor">
                <p><strong>Item Editor</strong></p>
                This item has no properties.
              </div>
            </div>            
            <div class="sidebar-ops" data-id="3">
              <p><strong>Widget Area</strong></p>
              <select id="add-widget-spinner">
                <?php foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) { ?>
                  <option value="<?php echo ucwords( $sidebar['id'] ); ?>">
                    <?php echo ucwords( $sidebar['name'] ); ?>
                  </option>
                <?php } ?>
                <option value="-1">(Add New Widget Area)</option>               
              </select>
              <div id="add-widget-area">
                <p class="ui-state-error">Warning: Creating a new widget area will save all changes.</p>
                <input type="text" style="width: 70%;"><button style="float: right; width: 20%" type="submit" class="button button-large">Add</button>
              </div>
            </div>            
          </div>
        </div>
      </div>
  <?php
}

function render_editor($col) {
  global $post;
  ?>
      <div class="wp-col-<?php echo $col; ?>">
        <?php wp_editor(stripslashes($post->post_content), 'content', array('mode' => 'specific_textareas','editor_selector' => 'tinymce-textarea')); ?>
      </div>
  <?php
}

add_meta_box('adv_ed_header_meta',__('Header'),'render_header_box','page','normal','high');
add_meta_box('adv_ed_meta',__('Advanced Page Editor'),'render_advanced_box','page','normal','high');
remove_post_type_support('page', 'editor');



