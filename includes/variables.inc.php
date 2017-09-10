<?php
/**
 * Variables and Constants
 *
 * This file contains constants and variables used by the Dashboard Weather Widget plugin
 * API info at: http://openweathermap.org/current
 *
 * @package    DashboardWeatherWidget
 * @since      1.0.0
 * @author     Tim Hurley
 */

// If accessed directly, die.
if ( ! defined( 'ABSPATH' ) ) {
	die();
}
// Constants to make life with include files easier.
define( 'DWW_PLUGIN_FILE', __FILE__ );                                          // /full/path/to/wp-content/plugins/plugin-folder/plugin-file.php .
define( 'DWW_PLUGIN_PATH', plugin_dir_path( DWW_PLUGIN_FILE ) );                // /full/path/to/wp-content/plugins/plugin-folder/ .
define( 'DWW_PLUGIN_URL' , plugin_dir_url( DWW_PLUGIN_FILE ) );                 // http://example.com/wp-content/plugins/drafts-for-friends/ .
define( 'DWW_PLUGIN_DIR',  basename( dirname( DWW_PLUGIN_FILE ) ) );            // /full/path/to/wp-content/plugins/plugin-folder/plugin-file.php .
// Not optional.
define( 'DWW_ICON_SIZE', '80' );                                                // Size in pixels of icon when displayed.
// Allow these to be overwritten from WordPress's wp-config file.
if ( ! defined( 'DWW_LOCATION_ID' ) ) {
	define( 'DWW_LOCATION_ID', '2208303' );                                       // http://bulk.openweathermap.org/sample/city.list.json.gz.
}
if ( ! defined( 'DWW_API_KEY' ) ) {
	// See http://openweathermap.org/appid for create.
	add_action( 'admin_notices', 'dww_admin_msg_key_error' );
}
if ( ! defined( 'DWW_UNITS' ) ) {
	define( 'DWW_UNITS', 'metric' );                                             // Default: kelvin, Metric: Celsius, imperial: Fahrenheit.
}
define( 'DWW_API_URL', 'https://api.openweathermap.org/data/2.5/weather?id=' . DWW_LOCATION_ID . '&units=' . DWW_UNITS . '&appid=' . DWW_API_KEY );
