<?php
// This file contains constants and variables used by the Dashboard Weather Widget plugin
// API info at: http://openweathermap.org/current

if ( !defined('ABSPATH') ) exit; // Exit if accessed directly


define( 'DWW_ICON_SIZE', '80' );                                 // Size in pixels of icon when displayed

// allow these to be overwritten from WordPRess's wp-config file
if ( !defined('DWW_LOCATION_ID') )
  define( 'DWW_LOCATION_ID', '2208303' );                        // http://bulk.openweathermap.org/sample/city.list.json.gz

if ( !defined('DWW_API_KEY') )
  define( 'DWW_API_KEY', '4349193c81834f3d66963837175d6cbc' );     // http://openweathermap.org/appid

if ( !defined('DWW_UNITS') )
  define( 'DWW_UNITS', 'metric' );                               // Default: kelvin, Metric: Celsius, imperial: Fahrenheit.

define( 'DWW_API_URL', 'https://api.openweathermap.org/data/2.5/weather?id=' . DWW_LOCATION_ID . '&units=' . DWW_UNITS . '&appid=' . DWW_API_KEY );
