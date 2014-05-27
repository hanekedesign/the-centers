var _$ = jQuery;

_$(function() {
  _$('#add-widget-area').hide();
  _$('.sidebar-ops').hide();
  
  _$('#adved_panelselect').change(function() {
    var val = _$(this).val();
    _$('.sidebar-ops').hide();
    _$('input, textarea, button, select',_$('.sidebar-ops')).prop('disabled', true);

    _$('.sidebar-ops').each(function(index,obj) {
      if (parseInt(_$(obj).data('id'),10) === parseInt(val,10)) {
        _$(obj).show();
        _$('input, textarea, button, select',_$(obj)).prop('disabled', false);
      }
    });
  });
  _$('#adved_panelselect').change();

  _$('#add-widget-spinner').change(function() {
    var val = _$(this).val();
    _$('#add-widget-area').hide();
    if (val === '-1') {
      _$('#add-widget-area').show();
    }
  });
  
  _$('#reset-form-box').click(function() {
    _$('#advedit_contact_form').val(
      "[header]Ask us a question[/header]\n" +
      "[text]Blue Bottle lomo literally, before they sold out mlkshk semiotics normcore ugh irony fashion axe direct[/text]\n" +
      "[textbox name=\"name\" placeholder=\"Your name\"]\n" +
      "[textbox name=\"email\" placeholder=\"Your email *\"]\n" +
      "[textbox name=\"phone\" placeholder=\"Your phone\"]\n" +
      "[textarea name=\"message\" placeholder=\"What are you interested in? *\"]\n" +
      "[submit]Send[/submit]"
    );
  });
  
  _$('.autotabs').each(function(id,node) {
    _$(node).click(function() {
      var group = _$(this).data('group');
      _$('.autotabs').each(function(id,node) {
        if (_$(node).data('group') === group) {
          _$(node).removeClass('active');
          _$(_$(node).data('target')).hide();
          _$('input, textarea, button, select',_$(_$(node).data('target'))).prop('disabled',true);
        }
      });
      _$(this).addClass('active');
      _$(_$(this).data('target')).show();
      _$('input, textarea, button, select',_$(_$(this).data('target'))).prop('disabled',false);
      _$(_$(this).data('field')).val(_$(this).data('id'));
    });
  });
  _$('.autotabs.active').click();
  
  // Adds color box support
  _$('.color-selector select').change(function(id,element) {
    _$('.color-box',_$(this).parent()).css('background-color',_$(this).find(':selected').data('color'));
    _$(_$(this).data('field')).val(_$(this).val());
  });
  _$('.color-selector select').change();

  /* Form Markup Editor */
  _$('#sidebar_form').on('itemClicked',function(self,item,selected) {
    if (selected === true) {
      _$('#item-editor').show();
      _$('#item-editor-type').val(get_field(item,'sidebar_form_type'));
      _$('#item-editor-text').val(get_field(item,'sidebar_form_text'));
      _$('#item-editor-name').val(get_field(item,'sidebar_form_name'));
      _$('#item-editor-placeholder').val(get_field(item,'sidebar_form_placeholder'));
      addChangeTriggers(item);
    } else {
      _$('#item-editor').hide();
    }
  });
  
  function addChangeTriggers(target) {
      // Remove old triggers
      _$('#item-editor-type, #item-editor-text, #item-editor-name, #item-editor-placeholder, #item-editor-default').unbind('change');
      _$('#item-editor-type, #item-editor-text, #item-editor-name, #item-editor-placeholder, #item-editor-default').change(function() {
        update_values(target);
        update_label(target);
      });
    
/*      _$('#item-editor-text').val(get_field(item,'sidebar_form_text'));
      _$('#item-editor-name').val(get_field(item,'sidebar_form_name'));
      _$('#item-editor-label').val(get_field(item,'sidebar_form_label'));
      _$('#item-editor-default').val(get_field(item,'sidebar_form_default'));*/
  }
  
  function update_values(target) {
    set_field(target, 'sidebar_form_type',_$('#item-editor-type').val(),true);
    set_field(target, 'sidebar_form_text',_$('#item-editor-text').val(),true);
    set_field(target, 'sidebar_form_name',_$('#item-editor-name').val(),true);
    set_field(target, 'sidebar_form_placeholder',_$('#item-editor-placeholder').val(),true);
    set_field(target, 'sidebar_form_value',_$('#item-editor-default').val(),true);
  }
  
  function update_label(target) {
    var labels = {
      "header": "Header",
      "subheader": "Subheader",
      "text": "Text",
      "textarea": "Text Area",
      "button": "Button"
    };
    _$(target).trigger('changeLabel',labels[get_field(target,'sidebar_form_type')]+": "+get_field(target,'sidebar_form_text'));
  }
  
  var file_frame;
  _$('.imgsel').live('click', function( event ){
    event.preventDefault();
    var me = _$(this);
    
    // If the media frame already exists, reopen it.
    /*if ( file_frame ) {
      file_frame.open();
      return;
    }*/
 
    // Create the media frame.
    file_frame = wp.media.frames.file_frame = wp.media({
      title: 'Select an Image',
      button: {
        text: 'Select',
      },
      multiple: false  // Set to true to allow multiple files to be selected
    });
 
    // When an image is selected, run a callback.
    file_frame.on( 'select', function() {
      // We set multiple to false so only get one image from the uploader
      attachment = file_frame.state().get('selection').first().toJSON();
      me.css('background-image','url('+attachment.url+')');
      _$('input[type=hidden]',me).val(attachment.id);
      // Do something with attachment.id and/or attachment.url here
    });
 
    // Finally, open the modal
    file_frame.open();
  });
  
  // Enable FAQ Editing
  if (_$('#faq_form').length > 0) {
    
    _$('#faq_form').on('itemClicked',function(self,item,selected) {
      if (selected === true) {
        _$('#question, #answer').prop('disabled',false);
        _$('#question, #answer').unbind('change');
        _$('#answer').val(get_field(item,'faq_text'));
        _$('#question').val(get_field(item,'faq_title'));
        _$('#question, #answer').change(function() {
          set_field(item,'faq_text',_$('#answer').val(),true);
          set_field(item,'faq_title',_$('#question').val(),true);
          _$(item).trigger('changeLabel', _$('#question').val());
        });
      } else {
        _$('#question, #answer').prop('disabled',true);
        _$('#question, #answer').val("");
      }
    });
    
    _$('#question, #answer').prop('disabled',true);
    _$('#question, #answer').val("");

  }
  
});

var tinyMceChange = function(ed, l) {
  alert("ok");
};