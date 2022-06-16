<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


function CSX_find_url_type($values){
  $interest=["url"];
  $keys=[];
  if(is_array($values)){
    foreach ($values as $key => $value){
      if (isset($value["type"]) && $value["type"] == "url") $keys[]=  $key;
    }
  }
  return $keys;
}
/* peopele keep getting errors from url types */
function CSX_remove_url_type(&$array){
  $keys=CSX_find_url_type($array);
  foreach($keys as $key){
    CSX_recursive_unset($array, $key);
  }
}

function CSX_clean_selector_value($values){
  $interest=["url"];
  if(is_array($values)){
    foreach ($values as $key => $value){
      if (in_array($key,$interest)) return $value;
    }
  }
  return $values;
}
function CSX_parse_selector($selector,$wrapper,$value){
  $clean_value=CSX_clean_selector_value($value);
  $selector = str_replace("{{WRAPPER}}",$wrapper,$selector);
  $selector = str_replace(["{{VALUE}}","{{URL}}","{{UNIT}}"],$clean_value,$selector);
  return $selector;
}
function CSX_recursive_unset(&$array, $unwanted_key) {
    unset($array[$unwanted_key]);
    foreach ($array as &$value) {
        if (is_array($value)) {
            CSX_recursive_unset($value, $unwanted_key);
        }
    }
}
// dynamic style for elements
function CSX_set_dynamic_style( \Elementor\Element_Base $element ) {
  global $xcs_render_dyno;
  if(!$xcs_render_dyno)
    return; // only act inside dyno
  list($PostID,$DynoID)=explode(",",$xcs_render_dyno);
  $ElementID = $element->get_ID();
  $dynamic_settings = $element->get_settings( '__dynamic__' );
  $all_controls = $element->get_controls();

  $all_controls = isset($all_controls) ? $all_controls : []; $dynamic_settings = isset($dynamic_settings) ? $dynamic_settings : [];
  $controls = array_intersect_key( $all_controls, $dynamic_settings );
  CSX_remove_url_type($controls);//we don't need the link options
  $settings = $element->parse_dynamic_settings( $dynamic_settings, $controls); // @ <- dirty fix for that fugly controls-stack.php  Illegal string offset 'url' error

  $CSX_css="";
  $element_wrapper="#post-{$PostID} .elementor-{$DynoID} .elementor-element.elementor-element-{$ElementID}";
  
  foreach($controls as $key => $control){
    if(isset($control["selectors"])){
        foreach($control["selectors"] as $selector => $rules){
          if(isset($settings[$key])) $CSX_css.= CSX_parse_selector($selector."{".$rules."}",$element_wrapper,$settings[$key]);        
        }

    }
  }
  

  echo $CSX_css ? "<style>".$CSX_css."</style>" :"";
  /* end custom css*/
}

add_action( 'elementor/frontend/section/before_render', 'CSX_set_dynamic_style' );
add_action( 'elementor/frontend/column/before_render', 'CSX_set_dynamic_style' );

add_action( 'elementor/frontend/widget/before_render', 'CSX_set_dynamic_style' );

//keep track of index

add_action( 'elementor/frontend/widget/before_render', function ( \Elementor\Element_Base $element ) {
  global $xcs_index;
	if ( 'posts' === $element->get_name() ||  'archive-posts' === $element->get_name()) {
		$xcs_index=0;
	}
} );