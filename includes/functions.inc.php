<?php
// This file contains functions used by the Dashboard Weather Widget plugin

if ( !defined('ABSPATH') ) exit; // Exit if accessed directly



/**
 * Grabs fresh data from the OpenWeather API.
 */
function dww_update_data() {
  // Check if the cached data is valid
  if ( false === ( $dww_data = get_transient( 'dww_data' ) ) ) {
    // It wasn't there, so grab a fresh copy of the data

    // Setup the request
    $request = wp_remote_get( DWW_API_URL );

    if ( is_wp_error( $request ) ) {
      // There's an issue with the API
      // ..hammering the API will get us blocked,
      // "Do not send requests more than 1 time per 10 minutes from one device/one API key",
      // so lets just use these are just fallbacks for a few mins then...

      $dww_data = [
        'location' 			=> 'Location unknown',
        'status' 				=> 'Error fetching data.',
        'description' 	=> '',
        'icon_filename' => '0',
        'temperature' 	=> '- ',
      ];

      set_transient( 'dww_data', $dww_data, 10 * MINUTE_IN_SECONDS );
    } // is_wp_error

    $body = wp_remote_retrieve_body( $request );

    $data = json_decode( $body );

    // if there's data
    if( ! empty( $data ) ) {
      $dww_data = [
      	'location' 			=> $data->name,                     // eg: "Brookvale"
      	'status' 	      => $data->weather[0]->main,         // eg: "Clear"
      	'description' 	=> $data->weather[0]->description,  // eg: "clear sky"
      	'icon_filename' => $data->weather[0]->icon,         // eg: "04n"
      	'temperature' 	=> round( $data->main->temp ),      // Rounds to full number for simplicity - eg: "13.92" becomes "13"
      ];
      // We've got the right data, so keep it for 45 mins
      set_transient( 'dww_data', $dww_data, 45 * MINUTE_IN_SECONDS );
    }

  } // if
} // dww_update_data()



/**
 * Creates the output shown within the inner section of the Dashboard Weather Widget, on the Dashboard.
 */
function dww_widget_output() {
  // Check if the cached data is valid
  dww_update_data();
  $dww_data = get_transient( 'dww_data' );


  // Icon
  echo "<img class='dww-icon' width='" . DWW_ICON_SIZE . "' height='" . DWW_ICON_SIZE . "' src='" . DWW_PLUGIN_URL . "icons/" . $dww_data['icon_filename'] . ".svg' alt='" . $dww_data['description'] . "'> ";

  // Location
  echo "<h3 class='dww-location' >".$dww_data['location']."</h3>";

  // Temperature
  echo "<p class='dww-temp'>".$dww_data['temperature']."&deg;C</p>";

  // Description
  echo "<p class='dww-desc'>".$dww_data['status']."</p>";
} // dww_widget_output()
