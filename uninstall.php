<?php

/**
 * Uninstallation. Runs on plugin removal.
 */

// If uninstall.php is not called by WordPress, die
if ( !defined('WP_UNINSTALL_PLUGIN') ) {
  die;
}

// Remove the transients from the DB.
delete_transient( 'dww_data' );
