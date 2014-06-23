/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can 
 * always reference jQuery with $, even when in .noConflict() mode.
 *
 * Google CDN, Latest jQuery
 * To use the default WordPress version of jQuery, go to lib/config.php and
 * remove or comment out: add_theme_support('jquery-cdn');
 * ======================================================================== */

(function($) {

// Use this variable to set up the common and page specific functions. If you 
// rename this variable, you will also need to rename the namespace below.
var Roots = {
  // All pages
  common: {
    init: function() {
      // JavaScript to be fired on all pages
    }
  },
  // Home page
  home: {
    init: function() {
      // JavaScript to be fired on the home page
    }
  },
  // About us page, note the change from about-us to about_us.
  about_us: {
    init: function() {
      // JavaScript to be fired on the about us page
    }
  }
};

// The routing fires all common scripts, followed by the page specific scripts.
// Add additional events for more control over timing e.g. a finalize event
var UTIL = {
  fire: function(func, funcname, args) {
    var namespace = Roots;
    funcname = (funcname === undefined) ? 'init' : funcname;
    if (func !== '' && namespace[func] && typeof namespace[func][funcname] === 'function') {
      namespace[func][funcname](args);
    }
  },
  loadEvents: function() {
    UTIL.fire('common');

    $.each(document.body.className.replace(/-/g, '_').split(/\s+/),function(i,classnm) {
      UTIL.fire(classnm);
    });
  }
};

$(document).ready(UTIL.loadEvents);
  
$('.accordion .body').hide(0);
$('.accordion .title').click(function() {
  $('.body',$(this).parent().parent()).slideUp('fast');
  if (!$('.body',$(this).parent()).is(':visible')) {
    $('.body',$(this).parent()).slideDown('fast');
  }
});
  
$('.more a').click(function() {
  var span = $('span',$(this).parent());
  var root = $(this);
  var trigger = span.slideToggle(300,function() {
    $(root).text(span.is(":hidden")?"More":"Less");
  });
  return false;
});

$('#news-archive').change(function(a,b) {
  document.location.href = $(this).val();
});
  
$('button[type=submit]').each(function(a,b) {
  var root = $(b).closest('form');
  var submit = $(this);
  
  if (!root.data('validated')) {
    return true;
  }
  
  $('input, textarea',root).on('input',function() { $(this).change(); });
  $('input, textarea',root).change(function() {
    var suben = true;
    $(this).removeClass("error-h");
    
    $('input, textarea',root).each(function(a,b) {
      $(b).removeClass("error");
      if ($(b).data('required') && $(b).val().trim() === "") {
        $(b).addClass("error");
        suben = false;
      }
      if ($(b).data('validation')) {
        switch ($(b).data('validation')) {
            case "email":
              var email = /[A-Z0-9\._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,12}/ig;
              if ($(b).val().trim() !== "" && !email.test($(b).val())) {
                suben = false;
                $(b).addClass("error");
              }
              break;
            case "phone":
              var phone = /^[0-9]{0,2}[-.\s]?[(]?[0-9]{3}[)]?[-.\s]?[0-9]{3}[-.\s]?[0-9]{4}$/igm;
              if ($(b).val().trim() !== "" && !phone.test($(b).val())) {
                suben = false;
                $(b).addClass("error");
              }
              break;
        }
      }
    });
    submit.data("disabled",!suben);
  });
  $('input, textarea',root).change();
});

$('button[type=submit]').click(function() {
  if ($(".error",$(this).closest('form')).length === 0) {
    $('#n8a8hspz').val(Date.now().toString(15));
    $('#n8a8hspz').attr('name','pzz35f2');
    return true;
  }
  $(".error",$(this).closest('form')).addClass("error-h");
  return false;
});

})(jQuery); // Fully reference jQuery after this point.




