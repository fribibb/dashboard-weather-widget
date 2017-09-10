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
function dww_load_textdomain() {
	load_plugin_textdomain( 'dashboardweatherwidget', false, DWW_PLUGIN_DIR . '/languages' );
}

/**
 * Add a widget to the dashboard.
 *
 * @package    DashboardWeatherWidget
 * @since      1.0.0
 */
function dww_add_dashboard_widgets() {
	wp_add_dashboard_widget(
		'dww',                                       // Widget slug.
		'Weather',                                   // Title.
		'dww_widget_output'                          // Display function.
	);
}

/**
 * Create the function to add plugin styles, but only to the Dashboard page
 *
 * @package    DashboardWeatherWidget
 * @since      1.0.0
 */
function dww_dashboard_styles() {
	// Load only on Dashboard page.
	$screen = get_current_screen();
	if ( 'dashboard' === $screen->id ) {
		wp_enqueue_style( 'dww_dashboard_css', plugins_url( 'css/style.css', __FILE__ ) );
	}
}

/**
 * Grabs fresh data from the OpenWeather API.
 *
 * @package    DashboardWeatherWidget
 * @since      1.0.0
 */
function dww_update_data() {
	// Check if there's a local copy.
	$dww_data = get_transient( 'dww_data' );
	// Check if the cached data is valid.
	if ( false === $dww_data ) {
		// It wasn't there, so grab a fresh copy of the data.
		// Setup the request.
		$request = wp_remote_get( DWW_API_URL );
		$body = wp_remote_retrieve_body( $request );
		$data = json_decode( $body );
		if ( is_wp_error( $request ) || empty( $data ) ) {
			// There's an issue with the API.
			// ..hammering the API will get us blocked,
			// Do not send requests more than 1 time per 10 minutes from one device/one API key,
			// so lets just use these are just fallbacks for a few mins then...
			$dww_data = [
				'location'      => 'Location unknown',
				'status'        => 'Error fetching data.',
				'description'   => '',
				'icon_filename' => '0',
				'temperature'   => '- ',
			];

			set_transient( 'dww_data', $dww_data, 10 * MINUTE_IN_SECONDS );
		}
		// If there's data.
		if ( ! empty( $data ) ) {
			$dww_data = [
				'location'      => $data->name,                         // eg: "Brookvale".
				'status'        => $data->weather[0]->main,             // eg: "Clear".
				'description'   => $data->weather[0]->description,      // eg: "clear sky".
				'icon_filename' => $data->weather[0]->icon,             // eg: "04n".
				'temperature'   => round( $data->main->temp ),          // Rounds to full number for simplicity - eg: "13.92" becomes "13".
			];
			// We've got the right data, so keep it for 45 mins.
			set_transient( 'dww_data', $dww_data, 45 * MINUTE_IN_SECONDS );
		}
	}
}

/**
 * Creates the output shown within the inner section of the Dashboard Weather Widget, on the Dashboard.
 *
 * @package    DashboardWeatherWidget
 * @since      1.0.0
 */
function dww_widget_output() {
	if ( defined( 'DWW_API_KEY' ) ) {
		// Check if the cached data is valid.
		dww_update_data();
		$dww_data = get_transient( 'dww_data' );
		// Icon.
		echo "<img class='dww-icon' width='" . esc_attr( DWW_ICON_SIZE ) . "' height='" . esc_attr( DWW_ICON_SIZE ) . "' src='" . esc_attr( DWW_PLUGIN_URL ) . 'icons/' . esc_attr( $dww_data['icon_filename'] ) . ".svg' alt='" . esc_attr( $dww_data['description'] ) . "'> ";
		// Location.
		echo "<h3 class='dww-location' >" . esc_html( $dww_data['location'] ) . '</h3>';
		// Temperature.
		echo "<p class='dww-temp'>" . esc_html( $dww_data['temperature'] ) . '&deg;C</p>';
		// Description.
		echo "<p class='dww-desc'>" . esc_html( $dww_data['status'] ) . '</p>';
	} else {
		echo "<p class='dww-error'>" . esc_html__( 'API key not set in', 'dashboardweatherwidget' ) . ' <em>wp-config.php</em>.</p>';
	}
}

/**
 * API Error Message
 *
 * Creates an error message, if no API key is set.
 *
 * @package    DashboardWeatherWidget
 * @since      1.0.0
 */
function dww_admin_msg_key_error() {
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
