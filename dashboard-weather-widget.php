<?php
/**
 * Plugin Name: Dashboard Weather Widget
 * Description: A demo plugin to show how to create a simple admin dashboard widget.
 * Version: 1.0.0
 * Author: Tim Hurley
 * Author URI: https://timhurley.net/
 * Requires at least: 4.8.0
 * Tested up to: 4.8.1
 *
 * @package    DashboardWeatherWidget
 * @since      1.0.0
 * @author     Tim Hurley
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Filesystem path to this file, eg: `/full/path/to/wp-content/plugins/plugin-folder/plugin-file.php`.
define( 'DWW_PLUGIN_FILE', __FILE__ );

// Includes.
require_once 'includes/variables.php';
require_once 'includes/functions.php';

// Add a widget to the dashboard.
add_action( 'wp_dashboard_setup', 'dww_add_dashboard_widgets' );

// Create the function to add plugin styles, but only to the Dashboard page.
add_action( 'admin_enqueue_scripts', 'dww_dashboard_styles' );
