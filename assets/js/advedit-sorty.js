/* Sortylist 
  (C) 2014 James Landrum
*/

// Because WP uses a framework that neess $.
_$ = jQuery;

_$(function() {
  // Tag Init
  var init_sorty = function() {
    _$('sl\\:sortylist').children(':not(sl\\:item):not(sl\\:controls)').remove();

    _$('sl\\:add').click(function() {
      var root = _$(this).parents('sl\\:sortylist');
      var label = root.data('default-label') || "New";
      var item = _$.parseHTML('<sl:item>'+label+'</sl:item>');
      if (_$('sl\\:item',root).length === 0) {
        root.prepend(item);
      } else {
        _$('sl\\:item',root).last().after(item);
      }
      configure_item(root);
    });
    
    _$('sl\\:sub').click(function() {
      var root = _$(this).parents('sl\\:sortylist');
      _$('sl\\:item.active',root).remove();
      update_form(root);
    });
    
    // Enable Selection
    _$('sl\\:sortylist').each(function(id,tag) {
      configure_item(tag);
    });
  };

  var configure_item = function(host) {
    if (_$(host).data('select')) {
      _$('sl\\:item',_$(host)).unbind('click');
      _$('sl\\:item',_$(host)).click(function() {
        if (_$(host).data('select') !== 'multi' && _$(host).data('select') !== 'single') {
          _$(host).trigger('itemClicked',[_$(this),_$(this).hasClass('active'),_$(host)]);
          return;
        }

        var wasActive = _$(this).hasClass('active');
        if ((!window.event.ctrlKey && !window.event.metaKey) || _$(host).data('select') !== 'multi') {
          _$(this).siblings().removeClass('active');
        }
        
        if (!wasActive) {
          _$(this).addClass('active');
        } else {
          _$(this).removeClass('active');
        }

        _$(host).trigger('itemClicked',[_$(this),_$(this).hasClass('active'),_$(host)]);
        return false;
      });
    }

    _$('sl\\:item',_$(host)).bind('changeLabel',function(event,name) {
      _$(this).text(name);
    });
    
    _$('sl\\:item',_$(host)).bind('setValue',function(event,field,value) {
      set_field(_$(this),field,value);
    });

    _$('sl\\:item',_$(host)).bind('clearValue',function(event,field) {
      clear_field(_$(this),field);
    });

    _$('sl\\:item',_$(host)).bind('getValue',function(event,field) {
      get_field(_$(this),field);
    });
    
    _$('sl\\:item',_$(host)).mousedown(function() {
      _$(this).data('is-mouse-down',true);
    });

    _$('sl\\:item',_$(host)).mouseup(function() {
      _$(this).data('is-mouse-down',false);
    });

    _$('sl\\:item',_$(host)).mousemove(function(e) {
      if (_$(host).data('dragging')) {
        if (_$(this).hasClass('moving')) { return; }
        var position = _$(this).position();
        var toTop = _$(this).height()/2 - ((e.pageY - position.top))>0;
        if (toTop) {
          _$('sl\\:sortylist.standard sl\\:item-placeholder').insertBefore(_$(this));
        } else {
          _$('sl\\:sortylist.standard sl\\:item-placeholder').insertAfter(_$(this));
        }
      } else if (_$(this).data('is-mouse-down')) {
        start_drag(_$(this));
      }
    });
        
    update_form(host);
  };
  
  var update_form = function(host) {
    var form = _$(host).data('form')||[];
    var defaults = _$(host).data('default')||[];

    _$('sl\\:item',_$(host)).each(function(index,item) {
      set_field(_$(item),'_id',""+index);
      for (var f in form) {
        set_field(_$(item),form[f],defaults[f],false);
      }
    });
  };
  
  var set_field = function(item,name,value,overwrite) {
    if (_$('input[type="hidden"][name="'+name+'[]"]',_$(item)).length > 0) {
      if (value!=null) {
        if (overwrite || _$('input[type="hidden"][name="'+name+'[]"]',_$(item)).val() == null) {
          _$('input[type="hidden"][name="'+name+'[]"]',_$(item)).val(value);
        }
      }
    } else {
      _$(item).append('<input type="hidden" name="'+name+'[]" value="'+(value||"")+'">');
    }
  };
  
  var clear_field = function(item,name) {
    _$('input[type="hidden"][name="'+name+'"][]',_$(item)).remove();
  };

  var get_field = function(item,name) {
    _$('input[type="hidden"][name="'+name+'"][]',_$(item)).remove();
  };
  
  var start_drag = function(item) {
    var root = _$(item).parents('sl\\:sortylist');
    var placeholder = _$(_$.parseHTML("<sl:item-placeholder><\\sl:item-placeholder>"));

    root.data('dragging',true);
    
    placeholder.html(_$(item).html());
              
    var mousemove = function(e) {
      root.prepend(_$(item));
      _$(item).offset({ left: e.pageX + 1, top: e.pageY + 1});
    };
          
    _$(item).before(placeholder);
    _$(item).addClass('moving');
    _$(item).data('is-mouse-down',false);
    _$(document).mousemove(mousemove);
    
    _$(document).one('mouseup',function() {
      root.data('dragging',false);
      _$(document).unbind('mousemove',mousemove);
      placeholder.replaceWith(_$(item));
      _$(item).removeClass('moving');
      _$(item).css('left', 0);
      _$(item).css('top', 0);
      _$(document).unbind('mouseup',this);
    });
  };
  
  init_sorty();
});

var SLGetSelected = function(host) {
  return _$('sl\\:item.active',_$(host));
};