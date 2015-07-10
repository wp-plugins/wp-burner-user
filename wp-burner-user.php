<?php
/*
 * Plugin Name: WP Burner User
 * Description: WP Burner User allows a WP admin to create an anonymous account with randomly generated data
 * Version: 	0.1.0
 * Author: 		Tony Hetrick
 * Author URI:	http://dev.tonyhetrick.com
 * License: 	GNU General Public License (GPL) version 2
 * License URI: https://www.gnu.org/licenses/gpl.html
 */

/*
	GNU General Public License (GPL) version 2
	Copyright (c) [2015] [tonyhetrick.com]

	WP Burner User is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 2 of the License, or
	any later version.
	 
	WP Burner User is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
	GNU General Public License for more details.
	 
	You should have received a copy of the GNU General Public License
	along with WP Burner User . If not, see https://www.gnu.org/licenses/gpl.html
	
*/

// Wordpress security recommendation
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

# Preliminary stuff

// Plugin base dir/url constants
define( "BU_PLUGIN_BASE_DIR", plugin_dir_path( __FILE__ ) );
define( "BU_PLUGIN_BASE_URL", plugins_url('', __FILE__) );

// Set the directory path information
$admin_dir = BU_PLUGIN_BASE_DIR . '/' . 'admin';
define( 'BU_ADMIN_DIR', $admin_dir );

$lib_dir = BU_PLUGIN_BASE_DIR . '/' . 'lib';
define( 'BU_LIB_DIR', $lib_dir );

// If logged in as admin, enable the admin panel
if ( 'is_admin' ) {
	require_once BU_ADMIN_DIR . '/class-bu-admin.php';
	require_once BU_LIB_DIR . '/bu-functions.php';
}

?>