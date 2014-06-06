<?php   

function render_header_box() {
  global $post;
  
  // Allow saving
  echo '<input type="hidden" name="post_update_file" value="advanced-edit-toolkit-save-fix.php">';

  $sel_id = get_post_meta($post->ID, 'advedit_header_mode', TRUE);
  $sel_id = empty($sel_id)?0:$sel_id;
  
  $sel_color = get_post_meta($post->ID, 'advedit_header_color', TRUE)?:"primary";

  wp_nonce_field( 'advedit_meta', 'advedit_meta_nonce' );

  $header_title = get_post_meta($post->ID, 'advedit_header_title', TRUE)?:"";
  $header_text = get_post_meta($post->ID, 'advedit_header_text', TRUE)?:"";
  $header_image = get_post_meta($post->ID, 'advedit_header_image', TRUE)?:0;

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
            <option value="gray-lighter" data-color="rgb(230,230,230)"<?php if($sel_color=="gray-lighter") echo " selected"?>>Light Gray</option>
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
          <?php $image = wp_get_attachment_image_src( $header_image , 'full' )?:array(""); ?>
          <div class="imgsel" style="background-image: url(<?php echo $image[0]; ?>)">
            <input type="hidden" id="advedit_header_image" name="advedit_header_image" value="<?php echo $header_image ?>">
          </div>
        </div>
        <div class="wp-col-6">
          <p><strong>Text</strong></p>
          <input type="text" placeholder="Header" id="advedit_header_title" name="advedit_header_title" value="<?php echo $header_title; ?>"><br/>
          <textarea placeholder="Content" id="advedit_header_text" name="advedit_header_text"><?php echo $header_text; ?></textarea>
        </div>
      </div>
      <div id="text" class="editor">
        <div class="wp-col-10">
          <p><strong>Text</strong></p>
          <input type="text" placeholder="Header" id="advedit_header_title" name="advedit_header_title" value="<?php echo $header_title; ?>"><br/>
          <textarea placeholder="Content" id="advedit_header_text" name="advedit_header_text"><?php echo $header_text; ?></textarea>
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
  } else if ($template_file === 'template-faq.php') {
    $pagetype = 3;
  } else if ($template_file === 'template-documents.php') {
    $pagetype = 4;
  } else if ($template_file === 'template-files.php') {
    $pagetype = 5;
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
        } else if ($pagetype === 3) {
          render_sidebar('3');
          render_faq_editor('9');
        } else if ($pagetype === 4) {
          render_documents_editor('12');
        } else if ($pagetype === 5) {
          render_files_editor('12');
        } else {
          render_editor('12');
        }
      ?>
    </div>
  </div>
<?php
} 

function render_faq_editor($col) {
  global $post;
  $panelmode = get_post_meta( $post->ID, 'advedit_panelmode', true );
  
  // Image Mode Stuff
  $image_blurb = get_post_meta( $post->ID, 'advedit_image_blurb', true );

  /*$header = get_post_meta( $post->ID, 'advedit_faq_root_title', true )?:"";
  $body = get_post_meta( $post->ID, 'advedit_faq_root_body', true )?:"";*/

  $titles = get_post_meta( $post->ID, 'advedit_faq_question', true )?:array();
  $texts = get_post_meta( $post->ID, 'advedit_faq_answer', true )?:array();

  ?>    
      <div class="wp-col-<?php echo $col; ?>">
        <!--<div class="postbox">
          <h4 class="hndle_"><span>FAQ Details</span></h4>
          <div class="inside">
            <p><strong>Title</strong></p>
            <input type="text" name="faq_root_title" value="<?php echo $header?:""; ?>">
            <p><strong>Paragraph</strong></p>
            <textarea name="faq_root_body"><?php echo $body?:""; ?></textarea>    
          </div>
        </div>-->
        <div class="postbox">
          <h4 class="hndle_"><span>FAQ Editor</span></h4>
          <div class="inside">        
            <div class="wp-container">
              <div class="wp-row">    
                <div class="wp-col-6 meta-box-sortables ui-sortable">

                  <sl:sortylist id="faq_form" class="standard" data-form='["faq_title","faq_text"]' data-default='["Question?","Answer"]' data-select="single" data-default-label="Question?">
                    
                  <?php 
                    for ($i = 0; $i < count($titles); $i++) {
                      ?>
                        <sl:item>
                          <?php echo $titles[$i]?:"Question?"; ?>
                          <input type="hidden" name="faq_title[]" value="<?php echo $titles[$i]?:"text"; ?>"/>
                          <input type="hidden" name="faq_text[]" value="<?php echo $texts[$i]?:""; ?>"/>
                        </sl:item>
                      <?php
                    }
                  ?>
                    
                    <sl:controls>
                      <sl:add>Add</sl:add>
                      <sl:sub>Delete</sl:sub>
                    </sl:controls>
                  </sl:sortylist>
                </div>
                <div class="wp-col-6 meta-box-sortables ui-sortable">
                  <p><strong>Entry Question</strong></p>
                  <input type="text" id="question">
                  <p><strong>Entry Answer</strong></p>
                  <textarea id="answer"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
<?php
}

function render_documents_editor($col) {
  global $post;

  $args = array(
      'post_type' => 'attachment',
      'numberposts' => -1,
      'post_status' => null,
      'post_parent' => null, // any parent
      ); 
  $attachments = get_posts($args);
  $map = array();
  if ($attachments) {
      foreach ($attachments as $posts) {
        $folder = get_post_meta($posts->ID, 'media_extensions_category', TRUE)?:null;
        if ($folder == null || in_array($folder, $map)) continue;
        $map[] = $folder;
      }
  }
  
  function getKeyName($str) {
    return strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $str));
  }

  ?>
      <div class="wp-col-<?php echo $col; ?>">
        <div class="postbox">
          <h4 class="hndle_"><span>Documents Root Editor</span></h4>
          <div class="inside">        
            <div class="wp-container">
              <div class="wp-row">    
                <div class="wp-col-12 meta-box-sortables ui-sortable inputmod">
                  When a new top level document type is added, it will appear on this list.
                  You can edit the description here.<br/>
                  <?php foreach ($map as $key) : ?>                    
                    <h2><?php echo $key ?></h2>
                    <input type="text" placeholder="Target URL" name="advedt_files_folder_desc[<?php echo getKeyName($key); ?>][url]" value="<?php echo get_post_meta($post->ID,'advedt_files_folder_link_'.getKeyName($key),true); ?>">
                    <textarea placeholder="Description" class="small" name="advedt_files_folder_desc[<?php echo getKeyName($key); ?>][desc]"><?php echo get_post_meta($post->ID,'advedt_files_folder_desc_'.getKeyName($key),true); ?></textarea>
                  <?php endforeach ?> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  <?php
}

function render_files_editor($col) {
  global $post;

  $args = array(
      'post_type' => 'attachment',
      'numberposts' => -1,
      'post_status' => null,
      'post_parent' => null, // any parent
      ); 
  $attachments = get_posts($args);
  $map = array();
  if ($attachments) {
      foreach ($attachments as $posts) {
        $folder = get_post_meta($posts->ID, 'media_extensions_category', TRUE)?:null;
        if ($folder == null || in_array($folder, $map)) continue;
        $map[] = $folder;
      }
  }
  
  function getKeyName($str) {
    return strtolower(preg_replace("/[^a-zA-Z0-9]+/", "", $str));
  }

  ?>
      <div class="wp-col-<?php echo $col; ?>">
        <div class="postbox">
          <h4 class="hndle_"><span>File Browser Editor</span></h4>
          <div class="inside">        
            <div class="wp-container">
              <div class="wp-row">    
                <div class="wp-col-12 meta-box-sortables ui-sortable inputmod">
                  Select a Top Level Category<br/>
                  <select name="advedt_files_browse_category" id="advedt_files_browse_category">
                  <option value="">All</option>
                  <?php foreach ($map as $key) : ?>                    
                    <option<?php if ($key == get_post_meta($post->ID,'advedt_files_browse_category',true)) echo " selected"; ?>><?php echo $key ?></option>
                  <?php endforeach ?> 
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  <?php
}

function render_sidebar($col) {
  global $post;
  $panelmode = get_post_meta( $post->ID, 'advedit_panelmode', true );
  
  // Image Mode Stuff
  $image_blurb = get_post_meta( $post->ID, 'advedit_image_blurb', true );

  $sidebar_siblm = get_post_meta( $post->ID, 'advedit_sidebar_sibling_menu', true )?:false;
  $sidebar_image = get_post_meta( $post->ID, 'advedit_sidebar_image', true )?:0;
  $sidebar_color = get_post_meta( $post->ID, 'advedit_sidebar_form_color', true )?:"primary";
  $sidebar_header = get_post_meta( $post->ID, 'advedit_sidebar_form_header', true)?:"";

  /*$sidebar_types = get_post_meta( $post->ID, 'advedit_sidebar_form_type', true )?:array();
  $sidebar_texts = get_post_meta( $post->ID, 'advedit_sidebar_form_text', true )?:array();
  $sidebar_names = get_post_meta( $post->ID, 'advedit_sidebar_form_name', true )?:array();
  $sidebar_place = get_post_meta( $post->ID, 'advedit_sidebar_form_placeholder', true )?:array();
  $sidebar_header = get_post_meta( $post->ID, 'advedit_sidebar_form_header', true)?:"";*/
  ?>    
      <div class="wp-col-<?php echo $col; ?> meta-box-sortables ui-sortable">
        <div class="postbox">
          <h4 class="hndle_"><span>Sidebar</span></h4>
          <div class="inside">
            <p><strong>Panel Type</strong></p>
            <select name="adved_panelselect" id="adved_panelselect">
              <option value="0"<?php if ($panelmode==0) echo " selected";?>>(No Sidebar)</option>
              <option value="1"<?php if ($panelmode==1) echo " selected";?>>Photo + Text</option>
              <option value="2"<?php if ($panelmode==2) echo " selected";?>>Form</option>
              <option value="3"<?php if ($panelmode==3) echo " selected";?>>Widget</option>
            </select><br/><br/>            
            <input type="checkbox" name="advedt_siblemenu" <?php if ($sidebar_siblm) echo "checked"?>><label for="advedt_siblemenu">Enable Sibling Menu</label>
            <div class="sidebar-ops" data-id="0">
              <p><strong>Panel Configuration</strong></p>
              <p>This panel does not contain any configurable options.</p>
            </div>
            <div class="sidebar-ops" data-id="1">
              <?php $image = wp_get_attachment_image_src( $sidebar_image , 'full' )?:Array(''); ?>
              <p><strong>Photo</strong></p>
              <div class="imgsel" style="background-image: url(<?php echo $image[0]; ?>)">
                <input type="hidden" name="advedit_sidebar_image" val="<?php echo $sidebar_image;?>">
              </div>
              <p><strong>Text</strong></p>
              <textarea name="advedit_image_blurb"><?php echo $image_blurb; ?></textarea>
            </div>    
            <div class="sidebar-ops" data-id="2">
              <p><strong>Form Color</strong></p>
              <div class="color-selector">
                <select data-field="#form-color" data-title="Theme" name="theme">
                  <option value="primary" data-color="rgb(245,192,65)"<?php if($sidebar_color=="primary") echo " selected"?>>Primary</option>
                  <option value="secondary" data-color="rgb(111,193,228)"<?php if($sidebar_color=="secondary") echo " selected"?>>Secondary</option>
                  <option value="tertiary" data-color="rgb(155,199,100)"<?php if($sidebar_color=="tertiary") echo " selected"?>>Tertiary</option>
                  <option value="gray" data-color="rgb(191,191,191)"<?php if($sidebar_color=="gray") echo " selected"?>>Gray</option>
                </select>          
                <div class="color-box" style="background-color: rgb(245, 192, 65);"></div>
                <input type="hidden" id="form-color" name="sidebar_form_color" value="primary">
              </div>
              <p><strong>Header Text</strong></p>
              <input type="text" name="sidebar_form_header" id="sidebar_form_header" value="<?php echo $sidebar_header; ?>">
              <p>
                <strong>Form Markup</strong></p>
                <textarea id="sidebar_form" name="sidebar_form"><?php echo get_post_meta( $post->ID, 'advedit_sidebar_form', true)?:"" ?></textarea>
              <div id="item-editor" style="display: none">
                <p><strong>Item Editor</strong></p>
                <p>Type</p>
                <select id="item-editor-type">
                  <option value="header">Header</option>
                  <option value="subheader">Subheader</option>
                  <option value="text">Text</option>
                  <option value="textarea">Text Area</option>
                  <option value="button">Button</option>
                </select>
                <p>Text</p>
                <input type="text" id="item-editor-text">
                <p>Name</p>
                <input type="text" id="item-editor-name">
                <p>Label</p>
                <input type="text" id="item-editor-placeholder">
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

function render_footer_box() {
  global $post;
  
  $sel_id = get_post_meta($post->ID, 'advedit_footer_mode', TRUE)?:0;

  ?>
  <div class="wp-container inputmod">
    <div class="wp-row">
      <div class="wp-col-2">
        <div class="selectbox">
          <div data-field="#footer-mode" data-group="footer" data-target="#fempty" class="autotabs<?php if($sel_id==0) echo " active"?>" data-id="0">No Footer</div>
          <div data-field="#footer-mode" data-group="footer" data-target="#two-one" class="autotabs<?php if($sel_id==1) echo " active"?>" data-id="1">Two + One</div>
          <div data-field="#footer-mode" data-group="footer" data-target="#four"    class="autotabs<?php if($sel_id==2) echo " active"?>" data-id="2">Four Box</div>
        </div>
        <input type="hidden" id="footer-mode" name="advedit_footer_mode" value="<?php echo $sel_id ?>">        
      </div>
      <div id="fempty" class="editor">
        <div class="wp-col-10">
          <p>This setting has no configurable options.</p>
        </div>
      </div>          
      <div id="two-one" class="editor">
        <div class="wp-col-10">
          <div class="wp-container">
            <div class="wp-row">
              <?php create_mini_editor(0); ?>
              <?php create_mini_editor(1); ?>
              <?php create_wide_editor(); ?>
            </div>
          </div>
        </div>
      </div>      
      <div id="four" class="editor">
        <div class="wp-col-10">
          <div class="wp-container">
            <div class="wp-row">
              <?php create_mini_editor(0); ?>
              <?php create_mini_editor(1); ?>
              <?php create_mini_editor(2); ?>
              <?php create_mini_editor(3); ?>
            </div>
          </div>
        </div>
      </div>   
    </div>  
  </div>      
  <?php
}


function create_wide_editor() {
  global $post;
  
  $header = get_post_meta($post->ID, 'advedt_widebox_header', TRUE)?:"";
  $buttona = get_post_meta($post->ID, 'advedt_widebox_button_label', TRUE)?:"";
  $buttonalink = get_post_meta($post->ID, 'advedt_widebox_button', TRUE)?:"";
  $buttonb = get_post_meta($post->ID, 'advedt_widebox_button_two_label', TRUE)?:"";
  $buttonblink = get_post_meta($post->ID, 'advedt_widebox_button_two', TRUE)?:"";
  ?>
      <div class="wp-col-6">
        <div class="small-box-editor">
          <input type="text" placeholder="Mini Header" class="header" name="advedt_widebox_header" value="<?php echo $header; ?>">            
          <input type="text" placeholder="Left Link Text" class="subheader" name="advedt_widebox_button_label" value="<?php echo $buttona; ?>">
          <input type="text" placeholder="Left Link Location" class="subheader" name="advedt_widebox_button" value="<?php echo $buttonalink; ?>">              
          <input type="text" placeholder="Right Link Text" class="subheader" name="advedt_widebox_button_two_label" value="<?php echo $buttonb; ?>">
          <input type="text" placeholder="Right Link Location" class="subheader" name="advedt_widebox_button_two" value="<?php echo $buttonblink; ?>">          
        </div>
      </div>
  <?php
}

function create_mini_editor($id) {
  global $post;
  
  $header = get_post_meta($post->ID, 'advedt_minibox_header_'.$id, TRUE)?:"";
  $text = get_post_meta($post->ID, 'advedt_minibox_text_'.$id, TRUE)?:"";
  $link = get_post_meta($post->ID, 'advedt_minibox_link_'.$id, TRUE)?:"";
  $link_text = get_post_meta($post->ID, 'advedt_minibox_link_text_'.$id, TRUE)?:"";
  $color = get_post_meta($post->ID, 'advedt_minibox_color_'.$id, TRUE)?:"";
    
  ?>
      <div class="wp-col-3">
        <div class="small-box-editor">
          <div class="color-selector">
            <select data-field="#minibox-color-<?php echo $id; ?>" data-title="Theme" name="advedt_minibox_color_<?php echo $id; ?>">
              <option value="primary" data-color="rgb(245,192,65)" <?php echo ($color=="primary")?"selected":""; ?>>Primary</option>
              <option value="secondary" data-color="rgb(111,193,228)" <?php echo ($color=="secondary")?"selected":""; ?>>Secondary</option>
              <option value="tertiary" data-color="rgb(155,199,100)" <?php echo ($color=="tertiary")?"selected":""; ?>>Tertiary</option>
              <option value="gray" data-color="rgb(191,191,191)" <?php echo ($color=="gray")?"selected":""; ?>>Gray</option>
            </select>          
            <div class="color-box" style="background-color: rgb(155, 199, 100);"></div>
            <input type="hidden" id="minibox-color-<?php echo $id; ?>" name="advedt_minibox-color-<?php echo $id; ?>" value="tertiary">
            <input type="text" placeholder="Content" class="subheader" name="advedt_minibox_text_<?php echo $id; ?>" value="<?php echo $text; ?>">            
            <input type="text" placeholder="Link Text" class="subheader" name="advedt_minibox_link_text_<?php echo $id; ?>" value="<?php echo $link_text; ?>">
            <input type="text" placeholder="Link Location" class="subheader" name="advedt_minibox_link_<?php echo $id; ?>" value="<?php echo $link; ?>">            
          </div>
        </div>
      </div>
  <?php
}

add_meta_box('adv_ed_header_meta',__('Header'),'render_header_box','page','normal','high');
add_meta_box('adv_ed_meta',__('Advanced Page Editor'),'render_advanced_box','page','normal','high');
add_meta_box('adv_ed_footer_meta',__('Footer'),'render_footer_box','page','normal','low');
remove_post_type_support('page', 'editor');



