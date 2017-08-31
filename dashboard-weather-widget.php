<?php
/**
 * Plugin Name: Dashboard Weather Widget
 * Description: A demo plugin to show how to create a simple admin dashboard widget.
 * Version: 1.0.0
 * Author: Tim Hurley
 * Author URI: https://timhurley.net/
 * Requires at least: 4.8.0
 * Tested up to: 4.8.1
 */

if ( !defined('ABSPATH') ) exit; // Exit if accessed directly



// Uncomment to enable degbugging while in development
// define( 'WP_DEBUG', true );

// We'll need these shortly
define( 'DWW_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'DWW_PLUGIN_URL' , plugin_dir_url( __FILE__ ) );



/**
 * Add a widget to the dashboard.
 */
function dww_add_dashboard_widgets() {
	wp_add_dashboard_widget(
   'dww',         									// Widget slug.
   'Weather',      									// Title.
   'dww_dashboard_widget_create'		// Display function.
  );
}
add_action( 'wp_dashboard_setup', 'dww_add_dashboard_widgets' );



/**
 * Create the function to output the contents of our Dashboard Widget.
 */
function dww_dashboard_widget_create() {
	require_once( 'includes/includes.inc.php' );	// We only need to use this here
	dww_widget_output();
}



/**
 * Create the function to add plugin styles, but only to the Dashboard page
 */
function dww_dashboard_styles() {
  // Load only on Dashboard page
	$screen = get_current_screen();
	if ($screen->id == "dashboard") {
    wp_enqueue_style( 'dww_dashboard_css', plugins_url('css/style.css', __FILE__) );
  }
}
add_action( 'admin_enqueue_scripts', 'dww_dashboard_styles' );
