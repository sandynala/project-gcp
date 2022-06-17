<?php 
//check if Elementor is installed

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function xcs_dependencies(){
  $xcs_elementor = true;
  
  if ( !xcs_is_plugin_active('elementor.php') ) $xcs_elementor=false;
  if ( !xcs_is_plugin_active('elementor-pro.php') ) $xcs_elementor=false;
  
  return $xcs_elementor;
}  

function xcs_clean_plugins($xcs_plugins){
  $results=[];
  foreach($xcs_plugins as $xcs_plugin){
    $folder="";
    $file="";
    list($folder,$file)=array_pad(explode('/',$xcs_plugin),2,"");
    if(!$file)  list($folder,$file)=array_pad(explode('\\',$xcs_plugin),2,""); // for windows
    $results[]=$file;
  }
  return $results;
}

function xcs_get_all_active_plugins(){

  if(function_exists('get_blog_option')){
    $xcs_multi_site = get_blog_option(get_current_blog_id(), 'active_plugins');
    $xcs_multi_site = isset($xcs_multi_site) ? $xcs_multi_site : [];
    $xcs_multi_sitewide=get_site_option( 'active_sitewide_plugins') ;
    if (is_array($xcs_multi_sitewide)) foreach($xcs_multi_sitewide as $xcs_key => $xcs_value){
      $xcs_multi_site[] = $xcs_key;  
    }
    $xcs_plugins = $xcs_multi_site;
  }
  else{
    $xcs_plugins = apply_filters( 'active_plugins', get_option( 'active_plugins' ) );
  }
  
  return  xcs_clean_plugins($xcs_plugins);
}

function xcs_is_plugin_active($plugin){
  $xcs_plugins = xcs_get_all_active_plugins();
  if ( in_array( $plugin ,$xcs_plugins) ) return true;
  return false;
}