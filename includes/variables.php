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
define( 'DWW_VERSION', '1.0.1' );

// Define paths and URLs.
// Filesystem path to folder with trailing slash, eg: `/full/path/to/wp-content/plugins/plugin-folder/`.
define( 'DWW_PLUGIN_PATH', plugin_dir_path( DWW_PLUGIN_FILE ) );
// Filesystem path to the base plugin file, eg: `/full/path/to/wp-content/plugins/plugin-folder/plugin-file.php`.
define( 'DWW_PLUGIN_DIR', basename( dirname( DWW_PLUGIN_FILE ) ) );
// Plugin folder URL with trailing slash, eg: `http://example.com/wp-content/plugins/plugin-folder/`.
define( 'DWW_PLUGIN_URL', plugin_dir_url( DWW_PLUGIN_FILE ) );

// Size in pixels of icon when displayed.
define( 'DWW_ICON_SIZE', '80' );

// Allow these variables to be overwritten from WordPress's wp-config file...

// API key, MUST be defined in wp-config.php to work.
if ( ! defined( 'DWW_API_KEY' ) ) {
	// See http://openweathermap.org/appid for create.
	add_action( 'admin_notices', 'dww_admin_msg_key_error' );

	// We can't continue without an API key...
	return;
}

// Location ID.
if ( ! defined( 'DWW_LOCATION_ID' ) ) {
	// See: http://bulk.openweathermap.org/sample/city.list.json.gz.
	define( 'DWW_LOCATION_ID', '2208303' );
}

// Temperature units.
if ( ! defined( 'DWW_UNITS' ) ) {
	// API options: kelvin (default) | metric(Celsius) | imperial(Fahrenheit).
	define( 'DWW_UNITS', 'metric' );
}

// Build the API URL...
$endpoint = 'http://api.openweathermap.org/data/2.5/weather';
$api_url  = esc_url(
	add_query_arg(
		array(
			'id'    => DWW_LOCATION_ID,
			'units' => DWW_UNITS,
			'appid' => DWW_API_KEY,
		),
		$endpoint
	)
);
// Define the API URL we'll use.
define( 'DWW_API_URL', $api_url );
