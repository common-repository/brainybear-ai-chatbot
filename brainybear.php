<?php
/*
Plugin Name: Brainybear AI Chatbot
description: Effortlessly train AI chatbots in just three clicks and provide instant customer support. This WordPress plugin integrates your Brainybear AI chatbot seamlessly, enhancing user engagement without the need to modify your theme. Manage your chatbots, view conversations, and track message credit balances directly within WordPress.
Version: 1.0.1
Author: Brainybear
Author URI: https://brainybear.ai
License: GPL2
*/

$version = "1.0.0";

if( !defined( 'ABSPATH' ) ) exit;

require_once( plugin_dir_path (__FILE__) .'functions.php' );

add_action( 'admin_menu', 'brainybearAI_info_menu' );  

add_action( 'admin_enqueue_scripts', 'brainybearAI_enqueue_styles_script' );

add_action('wp_footer', 'brainybearAI_frontendFooterScript');



if( !function_exists("brainybearAI_add_plugin_page_settings_link") ) { 

function brainybearAI_add_plugin_page_settings_link( $links ) {
	$links[] = '<a href="' .
		admin_url( 'admin.php?page=brainybearAI-info' ) .
		'">' . __('Settings') . '</a>';
	return $links;
}
// add settings link on the plugin page
add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'brainybearAI_add_plugin_page_settings_link');

}


if( !function_exists("brainybearAI_info_menu") ) { 
// add admin menu
function brainybearAI_info_menu(){    

	$footer_script = brainybearAI_get_option_footer_script();
	$footer_domain = brainybearAI_get_option_footer_domain();

	 
		$page_title = 'Brainybear';   
		$menu_title = 'Settings';   
		$menu_slug  = 'brainybearAI-info';   
		$function   = 'brainybearAI_info_page'; 
		$parent_slug = 'brainybearAI-info';
	 
	$capability = 'manage_options';  
	$icon_url   = plugin_dir_url( __FILE__ ).'assets/img/logo.jpg'; 
	$position   = 80; 

	add_menu_page( $page_title, 'Brainybear', $capability, $menu_slug, $function, $icon_url, $position ); 
	//add_submenu_page($menu_slug, $page_title, $menu_title, $capability, $menu_slug, $function,  $position );

 
 

	add_action( 'admin_init', 'brainybearAI_update_info' ); 
 
		$parent_slug = 'brainybearAI-info';  	
		$page_title = 'Brainybear Settings';   
		$menu_title = 'Settings';   
		$capability = 'manage_options';   
		$menu_slug  = 'brainybearAI-info';   
		$function   = 'brainybearAI_info_page';   
		$icon_url   = 'dashicons-chart-bar';  
		add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function,  $position );
 



} 

}



function brainybearAI_info_page(){ 
  include( plugin_dir_path( __FILE__ ) . 'options.php' );
} 

 
   

function brainybearAI_update_info() {   

  register_setting( 'brainybearAI-info-settings', 'brainybearAI_info' ); 

} 



if( !function_exists("brainybearAI_enqueue_styles_script") ) { 


function brainybearAI_enqueue_styles_script()
{

global $version;
    if( is_admin() ) {              

        $css= plugins_url() . '/'.  basename(dirname(__FILE__)) . "/style.css";

     wp_enqueue_style( 'brainybearAI-css', $css, array(), $version);
     wp_enqueue_style( 'brainybearAI-font-main-css', plugins_url() . '/'.  basename(dirname(__FILE__)) . "/assets/css/main.css", array(), $version, true);
  
 
        

    }

}

}

if( !function_exists("brainybearAI_frontendFooterScript") ) { 

	function brainybearAI_frontendFooterScript(){
		
		brainybearAI_output();
		
	}

}


function brainybearAI_ordinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
    else
        return $number. $ends[$number % 10];
}

function brainybearAI_matchElement($str){
    switch($str){
        case "A":
        return "Anchor Link <".strtolower($str).">";
        break;
        case "DIV":
        return "Division";
        case "IMG":
        return "Image";
        case "P":
        return "Paragraph";
        case "SECTION":
        return "Section";
        case "INPUT":
        return "Input";
        case "BUTTON":
        return "Button";
        default:
        return $str;    
    }
}
?>
