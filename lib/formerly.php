<?php

$incrmt = 0;

function gen_opt_field($name, $val) {
  if ($val == null) return "";
  return " $name=\"$val\" ";
}

function gen_size_class($size, $extraval) {
  $sizeclass = "input-col-12";  
  switch ($size) {
    case "none":
      $sizeclass = "input-col-none";
    case "half":
      $sizeclass = "input-col-6";
    case "full":
    default:
      $sizeclass = "input-col-12";
  }
  $class = trim($sizeclass . " " . $extraval);
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
  
  return "<form action=\"$action\" name=\"$name\"" . gen_opt_field("redirect",$redirect) . gen_opt_field("target",$target) . gen_opt_field("class",$class) . "method=\"$method\">" . "<input type=\"hidden\" name=\"redirect-target\" value=\"$redirect\">" . do_shortcode($content) . "</form>";
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
  $size =        val_if_exists($params,'size')?:null;
  $name =        val_if_exists($params,'name')?:"my-form-" . ++$incrmt;
  $required =    val_if_exists($params,'required')?:false;
  $placeholder = val_if_exists($params,'label')?:"";
  if ($required) $placeholder .= " *";

  return "<input name=\"$name\" placeholder=\"$placeholder\" type=\"text\" data-required=\"" . ($required?"true":"false") . "\" " . gen_size_class($size, $class) . ">";
}

function sc_textarea($params, $content) {
  $class =       val_if_exists($params,'class')?:null;
  $size =        val_if_exists($params,'size')?:null;
  $name =        val_if_exists($params,'name')?:"my-form-" . ++$incrmt;
  $required =    val_if_exists($params,'required')?:false;
  $placeholder = val_if_exists($params,'label')?:"";
  if ($required) $placeholder .= " *";

  return "<textarea name=\"$name\" placeholder=\"$placeholder\" type=\"text\" data-required=\"" . ($required?"true":"false") . "\" " . gen_size_class($size, $class) . ">" . do_shortcode($content) . "</textarea>";
}

function sc_select($params, $content) {
  $class =       val_if_exists($params,'class')?:null;
  $size =        val_if_exists($params,'size')?:null;
  $name =        val_if_exists($params,'name')?:"my-form-" . ++$incrmt;
  $required =    val_if_exists($params,'required')?:false;

  function sc_option($params, $content) {
    $class = val_if_exists($params,'class')?:null;
    $label = val_if_exists($params,'label')?:"";
    $value = val_if_exists($params,'value')?:$label;

    return "<option" . gen_opt_field("value",$class) . ">" . $content . "</option>";
  }
  
  add_shortcode('option','sc_option');
  $return = "<select name=\"$name\"  type=\"text\" data-required=\"" . ($required?"true":"false") . "\" " . gen_size_class($size, $class) . ">" . do_shortcode($content) . "</select>";
  remove_shortcode('option');
  return $return;
}

function sc_checkbox($params, $content) {
  $class =       val_if_exists($params,'class')?:null;
  $size =        val_if_exists($params,'size')?:null;
  $name =        val_if_exists($params,'name')?:"my-form-" . ++$incrmt;
  $required =    val_if_exists($params,'required')?:false;
  $placeholder = val_if_exists($params,'label')?:"";
  if ($required) $placeholder .= " *";

  return "<div". gen_size_class($size, "checkbox " . $class) . "><input type=\"checkbox\" name=\"$name\" placeholder=\"$placeholder\" data-required=\"" . ($required?"true":"false") . "\">" . $content . "</div>";
}

function sc_submit($params, $content) {
  $class =       val_if_exists($params,'class')?:"btn btn-default";
  $size =        val_if_exists($params,'size')?:null;
  $name =        val_if_exists($params,'name')?:"my-form-" . ++$incrmt;
  
  return "<button class=\"$class\" name=\"$name\" type=\"submit\" " . gen_size_class($size, $class) . ">$content</button>";
}

add_shortcode('form','sc_form');
add_shortcode('header','sc_header');
add_shortcode('text','sc_text');
add_shortcode('checkbox','sc_checkbox');
add_shortcode('textbox','sc_textbox');
add_shortcode('textarea','sc_textarea');
add_shortcode('select','sc_select');
add_shortcode('submit','sc_submit');

