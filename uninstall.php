<?php
/**
 * Uninstallation. Runs on plugin removal.
 *
 * @package    DashboardWeatherWidget
 * @since      1.0.0
 * @author     Tim Hurley
 */

// If uninstall.php is not called by WordPress, die.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die();
}

// Remove the transients from the DB.
delete_transient( 'dww_data' );
