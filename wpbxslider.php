<?php
   /*
   Plugin Name: WPBXSlider
   Plugin URI: https://crescentsoftware.ca/wpbxslider
   Description: a plugin for Steven Wanderski's bxslider
   Version: 1.0
   Author: Gregory Johnson
   Author URI: https://crescentsoftware.ca
   License: MIT
   */

   // If this file is called directly, abort.
  if ( ! defined( 'WPINC' ) ) {
    die;
  }
  
  /**
   * Includes the core plugin class for executing the plugin.
   */
  require_once( plugin_dir_path( __FILE__ ) . 'admin/WPBXSlider.php' );

  function wpbxslider_custom_admin_settings() {
    $plugin = new WPBXSlider();
    $plugin->run();
  }

  add_action( 'plugins_loaded', 'wpbxslider_custom_admin_settings' );
  