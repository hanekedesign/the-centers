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
  
  /*_$('.selectbox div').click(function() {
    //_$('.selectbox div').removeClass('active');
    //_$(this).addClass('active');
  });*/
  
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
  _$('#shorty').on('itemClicked',function(self,item,selected) {
    if (selected === true) {
      _$('#item-editor').show();
    } else {
      _$('#item-editor').hide();
    }
  });
});