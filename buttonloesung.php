<?php
/**
 * Plugin Name: Buttonloesung
 * Plugin URI: Not available
 * Description: Buttonlösung für deutsche woomommerce-Stores.
 * Version: 1.0
 * Author: waldio
 */

//Exit if accessed directly
 if(!defined('ABSPATH')){
 	exit;
 }

$defaults = buttonloesung_init();

//Load the global options variable
$buttonloesung_options = get_option('buttonloesung_settings', $defaults);

if(is_admin()){
  //Load Settings
  require_once(plugin_dir_path(__FILE__).'/includes/buttonloesung_options.php');
  //Adds a link to the settings page on the plugin overview page
  function buttonloesung_add_plugin_page_settings_link( $links ) {
   $testparameter = site_url("wp-admin/options-general.php?page=buttonloesung-options");
   $links[] = '<a href=" ' . $testparameter . ' ">' . __('Settings') . '</a>';
   return $links;
  }
  add_filter('plugin_action_links_'.plugin_basename(__FILE__), 'buttonloesung_add_plugin_page_settings_link');
 }


if(buttonloesung_checkLanguages()){
  buttonloesung_runPlugin();
}

function buttonloesung_init(){
  $default = [
    "agb_text" => 'Mit deiner Bestellung erklärst du dich mit unseren <a href="#"> Allgemeinen Geschäftsbedingungen</a>, <a href="#">Wiederrufsbestimmungen</a> und <a href="#"> Datenschutzbestimmungen</a> einverstanden.',
    "button_text" => "Kaufen",
    "shippingdateestimatemin" => 1,
    "shippingdateestimatemax" => 3
  ];
  return $default;
}

function buttonloesung_runPlugin(){
  //Checks if woomommerce is active
  if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

      //Changes the text of the "buy now"-Button
      require_once(plugin_dir_path(__FILE__).'/includes/buttonloesung_buybutton.php');

      //Reorders the elements of the checkout page
      require_once(plugin_dir_path(__FILE__).'/includes/buttonloesung_checkout.php');

      //Add shipping estimate date
      require_once(plugin_dir_path(__FILE__).'/includes/buttonloesung_shippingdate.php');
    }
}

function buttonloesung_checkLanguages(){
  if($buttonloesung_options["language"]){
    if(function_exists("pll_current_language")){
      if (pll_current_language() == 'de'){
        return TRUE;
      }
    }
    if(get_locale() == "de_DE"){
      return TRUE;
    }
    return FALSE;
  }
  return TRUE;
}
