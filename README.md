# Dashboard Weather Widget
By [Tim Hurley](https://timhurley.net)



## Description

A demo plugin to show how to create a simple admin dashboard widget.



## Usage

Once activated, you will see this has been added to your dashboard page.

The following can be optionally set within your wp-config.php file:

`define( 'WW_LOCATION_ID', '2208303' );`

`define( 'WW_API_KEY', 'ABC123' );`

`define( 'WW_UNITS', 'metric' );`

Details at:  http://openweathermap.org/appid



## Installation

Installing "Dashboard Weather Widget" can be done either by searching for "Dashboard Weather Widget" via the "Plugins > Add New" screen in your WordPress dashboard, or by using the following steps:

1. Download the plugin via GitHub.
2. Upload the ZIP file through the "Plugins > Add New > Upload" screen in your WordPress dashboard.
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Visit the settings screen and configure, as desired.



## Changelog

= 1.0.0 =
* Initial release



## To Do

* Allow for option to set via web interface rather than just constants
* ...maybe base temp units and location off WP Timezone city/location setting?
* Improve output if error fetching new data



## License

* GPLv3 or later
* http://www.gnu.org/licenses/gpl-3.0.html



## Credits

* Dripicons - by [Amit Jakhu](http://www.amitjakhu.com).
* Warning icon - from [Font Awesome](http://fontawesome.io/).



## My thoughts on the test
I was plesantly surprised by this test! I have seen some relevant coding tests, but thankfully this was not one! :)

It covers API usage, WordPress intergration and scalability considerations with the use of the WP Transients API.
