# Dashboard Weather Widget

By [Tim Hurley](https://timhurley.net)

## Description

A demo plugin to show how to create a simple admin dashboard widget.

## Usage

Once activated, you will see this has been added to your dashboard page.

The following can be optionally set within your wp-config.php file:

`define( 'DWW_LOCATION_ID', '2208303' );`

`define( 'DWW_UNITS', 'metric' );`

Details at:  <http://openweathermap.org/appid>

## Installation

Installing "Dashboard Weather Widget" can be done either by searching for "Dashboard Weather Widget" via the "Plugins > Add New" screen in your WordPress dashboard, or by using the following steps:

1. Download the plugin via GitHub.
2. Upload the ZIP file through the "Plugins > Add New > Upload" screen in your WordPress dashboard.
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Create an API key at <http://openweathermap.org/>
5. Add it to your wp-config.php file. Like so: `define( 'DWW_API_KEY', 'ABC123' );`

## Changelog

= 1.0.0 =

* Initial release

## To Do

* Allow for option to set via web interface rather than just constants
* ...maybe base temp units and location off WordPress's time zone city/location setting?
* Improve output if error fetching new data

## License

* GPLv3 or later
* <http://www.gnu.org/licenses/gpl-3.0.html>

## Credits

* Dripicons weather icons by [Amit Jakhu](http://www.amitjakhu.com).
* Warning icon from [Font Awesome](http://fontawesome.io/).

## My thoughts on the test

I was pleasantly surprised by this test! I have seen some relevant coding tests, but thankfully this was not one! :)

It covers API usage, WordPress integration and scalability considerations with the use of the WP Transients API.
