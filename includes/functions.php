<?php
/**
 * Common Functions
 *
 * Functions used by the Dashboard Weather Widget plugin
 *
 * @package    DashboardWeatherWidget
 * @since      1.0.0
 * @author     Tim Hurley
 */

// If accessed directly, die.
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Loads text domain for l10n.
 *
 * @since      2.3.0
 */
function dww_load_textdomain(): void {
	load_plugin_textdomain( 'dashboardweatherwidget', false, DWW_PLUGIN_DIR . '/languages' );
}

/**
 * Add a widget to the dashboard.
 *
 * @package    DashboardWeatherWidget
 * @since      1.0.0
 */
function dww_add_dashboard_widgets(): void {
	wp_add_dashboard_widget(
		'dww',                                                                  // Widget slug.
		'Weather',                                                              // Title.
		'dww_widget_output'                                                     // Display function.
	);
}

/**
 * Create the function to add plugin styles, but only to the Dashboard page
 *
 * @package    DashboardWeatherWidget
 * @since      1.0.0
 */
function dww_dashboard_styles(): void {
	// What screen are we on?
	$screen = get_current_screen();

	// Load only on WordPress Dashboard page.
	if ( 'dashboard' === $screen->id ) {
		wp_enqueue_style( 'dww_dashboard_css', plugins_url( 'css/style.css', DWW_PLUGIN_FILE ), array(), DWW_VERSION );
	}
}

/**
 * Grabs fresh data from the OpenWeather API.
 *
 * @package    DashboardWeatherWidget
 * @since      1.0.0
 */
function dww_update_data(): void {
	// Check if there's a local copy.
	$dww_data = get_transient( 'dww_data' );

	// Check if the cached data is valid.
	if ( false !== $dww_data ) {
		// The data is still fresh, so just use that.
		return;
	}

	// It wasn't cached, grab a fresh copy of the data...

	// Setup the request.
	$request = wp_remote_get( DWW_API_URL );
	$body    = wp_remote_retrieve_body( $request );
	$data    = json_decode( $body );

	// Check for errors in the response.
	// cod!=200 means there was an error.
	if ( is_wp_error( $request ) || empty( $data ) || 200 !== $data->cod ) {
		// There's an issue with the API.
		// ..hammering the API will get us blocked,
		// Do not send requests more than 1 time per 10 minutes from one device/one API key,
		// so lets just use these are just fallbacks for a few mins then...
		$dww_data = array(
			'location'      => 'Location unknown',
			'status'        => 'Error fetching data.',
			'description'   => '',
			'icon_filename' => '0',
			'temperature'   => '- ',
		);

		set_transient( 'dww_data', $dww_data, 10 * MINUTE_IN_SECONDS );

		return;
	}

	// If there's data.
	$dww_data = array(
		'location'      => $data->name,                                         // eg: "Brookvale".
		'status'        => $data->weather[0]->main,                             // eg: "Clear".
		'description'   => $data->weather[0]->description,                      // eg: "clear sky".
		'icon_filename' => $data->weather[0]->icon,                             // eg: "04n".
		'temperature'   => round( $data->main->temp ),                          // Rounds to full number for simplicity - eg: "13.92" becomes "13".
	);

	// We've got the right data, so keep it for 45 mins.
	set_transient( 'dww_data', $dww_data, 45 * MINUTE_IN_SECONDS );
}

/**
 * Creates the output shown within the inner section of the Dashboard Weather Widget, on the Dashboard.
 *
 * @package    DashboardWeatherWidget
 * @since      1.0.0
 */
function dww_widget_output(): void {
	if ( ! defined( 'DWW_API_KEY' ) ) {
		dww_output_error_html( __( 'API key not set in wp-config.php.', 'dashboardweatherwidget' ) );
	}

	// Check if the cached data is valid.
	dww_update_data();
	$dww_data = get_transient( 'dww_data' );

	// Check if there was data returned.
	if ( false === $dww_data ) {
		// If there's no data, show an error.
		dww_output_error_html( __( 'Error fetching data.', 'dashboardweatherwidget' ) );
		return;
	}

	// Check we have each of the required fields.
	$fields       = array( 'location', 'status', 'description', 'icon_filename', 'temperature' );
	$empty_fields = array();
	foreach ( $fields as $field ) {
		if ( empty( $dww_data[ $field ] ) ) {
			$empty_fields[] = $field;
		}
	}
	if ( ! empty( $empty_fields ) ) {
		// If there's no data, show an error.
		dww_output_error_html( __( 'Error in data response.', 'dashboardweatherwidget' ) );

		// List any fields that were not set.
		dww_output_error_html( __( 'Missing/invalid ', 'dashboardweatherwidget' ) . ' ' . implode( ', ', $empty_fields ) . '.' );

		return;
	}

	// Build the output...
	// Icon.
	$icon_url = DWW_PLUGIN_URL . 'icons/' . $dww_data['icon_filename'] . '.svg';
	echo '<img class="dww-icon" width="' . esc_attr( DWW_ICON_SIZE ) . '" height="' . esc_attr( DWW_ICON_SIZE ) . '" src="' . esc_url( $icon_url ) . '" alt="' . esc_attr( $dww_data['description'] ) . '"> ';
	// Location.
	echo '<h3 class="dww-location">' . esc_html( $dww_data['location'] ) . '</h3>';
	// Temperature.
	echo '<p class="dww-temp">' . esc_html( $dww_data['temperature'] ) . '&deg;C</p>';
	// Description.
	echo '<p class="dww-desc">' . esc_html( $dww_data['status'] ) . '</p>';
}

/**
 * Error Message
 *
 * Creates an error message (in HTML) to be output.
 *
 * @package    DashboardWeatherWidget
 * @since      1.0.1
 *
 * @param string $message The error message to display.
 *
 * @return void
 */
function dww_output_error_html( string $message ): void {
	echo '<p class="dww-error">' . esc_html( $message ) . '</p>';
}

/**
 * API Error Message
 *
 * Creates a dashboard error message, if no API key is set.
 *
 * @package    DashboardWeatherWidget
 * @since      1.0.0
 */
function dww_admin_msg_key_error(): void {
	?>
	<div class="error notice">
		<p>
			<strong><?php esc_html_e( 'Dashboard Weather Widget', 'dashboardweatherwidget' ); ?></strong>
			<?php esc_html_e( 'requires you must set an API key in', 'dashboardweatherwidget' ); ?>
			<em>wp-config.php</em>
		</p>
	</div>
	<?php
}
