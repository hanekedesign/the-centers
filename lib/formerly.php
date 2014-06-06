<?php

$incrmt = 0;

function gen_opt_field($name, $val, $rep = null) {
  if ($val == null) return "";
  
  $ins = " $name=\"" . ($rep?:$val) . "\" ";
  return $ins;
}

function gen_size_class($size) {
  $sizeclass = "input-col-12";  
  switch ($size) {
    case "none":
      $sizeclass = "input-col-none";
      break;
    case "half":
      $sizeclass = "input-col-6";
      break;
    case "full":
    default:
      $sizeclass = "input-col-12";
  }
  $class = trim($sizeclass);
  return " class=\"$class\" ";
}

function val_if_exists($val,$key) {
  if (isset($val[$key])) return $val[$key];
  return null;
}
function sc_form($params, $content) {
  $name =   val_if_exists($params,'name')?:"my-form-" . ++$incrmt;
  $target = val_if_exists($params,'target')?:null;
  $method = val_if_exists($params,'method')?:"post";
  $class =  val_if_exists($params,'class')?:null;
  $action = val_if_exists($params,'action')?:"/";
  $redirect = val_if_exists($params,'redirect')?:"";
  
  return "<form data-validated=\"true\" action=\"$action\" name=\"$name\"" . gen_opt_field("redirect",$redirect) . gen_opt_field("target",$target) . gen_opt_field("class",$class) . "method=\"$method\">" . 
    "<input type=\"hidden\" name=\"__process_form\" value=\"true\">" .
    "<input type=\"hidden\" name=\"__process_form_action\" value=\"$action\">" .
    "<input type=\"hidden\" name=\"redirect_target\" value=\"$redirect\">" .
    do_shortcode($content) . "</form>";
}

function sc_header($params, $content) {
  $size = val_if_exists($params,'size')?:3;
  $class = val_if_exists($params,'class')?:null;
  
  return "<h$size" . gen_opt_field("class",$class) . ">" . do_shortcode($content) . "</h$size>";
}

function sc_text($params, $content) {
  $class = val_if_exists($params,'')?:null;
  
  return "<p" . gen_opt_field("class",$class) . ">" . do_shortcode($content) . "</p>";
}

function sc_textbox($params, $content) {
  $class =       val_if_exists($params,'class')?:null;
  $size =        val_if_exists($params,'size')?:"full";
  $name =        val_if_exists($params,'name')?:"my-form-" . ++$incrmt;
  $required =    val_if_exists($params,'required')?:false;
  $placeholder = val_if_exists($params,'label')?:"";
  if ($required) $placeholder .= " *";

  return "<div ". gen_size_class($size, $class) ."><input name=\"formerly_form[$name]\" placeholder=\"$placeholder\" type=\"text\" data-required=\"" . ($required?"true":"false") . gen_opt_field("class",$class) . "\" ></div>";
}

function sc_textarea($params, $content) {
  $class =       val_if_exists($params,'class')?:null;
  $size =        val_if_exists($params,'size')?:"full";
  $name =        val_if_exists($params,'name')?:"my-form-" . ++$incrmt;
  $required =    val_if_exists($params,'required')?:false;
  $placeholder = val_if_exists($params,'label')?:"";
  if ($required) $placeholder .= " *";

  return "<div ". gen_size_class($size, $class) ."><textarea name=\"formerly_form[$name]\" placeholder=\"$placeholder\" type=\"text\" data-required=\"" . ($required?"true":"false") . gen_opt_field("class",$class) . "\">" . do_shortcode($content) . "</textarea></div>";
}

function sc_select($params, $content) {
  $class =       val_if_exists($params,'class')?:null;
  $size =        val_if_exists($params,'size')?:"full";
  $name =        val_if_exists($params,'name')?:"my-form-" . ++$incrmt;
  $required =    val_if_exists($params,'required')?:false;

  function sc_option($params, $content) {
    $class = val_if_exists($params,'class')?:null;
    $label = val_if_exists($params,'label')?:"";
    $value = val_if_exists($params,'value')?:$label;

    return "<option" . gen_opt_field("value",$class) . ">" . $content . "</option>";
  }
  
  add_shortcode('option','sc_option');
  $return = "<div ". gen_size_class($size, $class) ."><select name=\"formerly_form[$name]\"  type=\"text\" data-required=\"" . ($required?"true":"false") . gen_opt_field("class",$class) . "\">" . do_shortcode($content) . "</select></div>";
  remove_shortcode('option');
  return $return;
}

function sc_checkbox($params, $content) {
  $class =       val_if_exists($params,'class')?:null;
  $size =        val_if_exists($params,'size')?:"full";
  $name =        val_if_exists($params,'name')?:"my-form-" . ++$incrmt;
  $required =    val_if_exists($params,'required')?:false;
  $placeholder = val_if_exists($params,'label')?:"";
  if ($required) $placeholder .= " *";

  return "<div ". gen_size_class($size, $class) ."><div". gen_size_class($size, "checkbox " . $class) . "><input type=\"checkbox\" name=\"formerly_form[$name]\" placeholder=\"$placeholder\" data-required=\"" . ($required?"true":"false") . gen_opt_field("class",$class) . "\">" . $content . "</div></div>";
}

function sc_submit($params, $content) {
  $class =       val_if_exists($params,'class')?:"btn btn-default";
  $size =        val_if_exists($params,'size')?:"full";
  $name =        val_if_exists($params,'name')?:null;
  
  return "<div ". gen_size_class($size) ."><button class=\"$class\"" . gen_opt_field("name",$name,"formerly_form[$name]") . gen_opt_field("class",$class) . "type=\"submit\">$content</button></div>";
}

add_shortcode('form','sc_form');
add_shortcode('header','sc_header');
add_shortcode('text','sc_text');
add_shortcode('checkbox','sc_checkbox');
add_shortcode('textbox','sc_textbox');
add_shortcode('textarea','sc_textarea');
add_shortcode('select','sc_select');
add_shortcode('submit','sc_submit');

