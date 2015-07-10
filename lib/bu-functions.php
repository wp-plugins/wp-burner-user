<?php
/*
 * General functions or utilities for WP Burner User
 *	
 * LICENSE: GNU General Public License (GPL) version 2
 *
 * @author     Tony Hetrick
 * @copyright  [2015] [tonyhetrick.com]
 * @license    https://www.gnu.org/licenses/gpl.html
*/

# Wordpress security recommendation
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * BU_Functions contains commonly used static functions 
 *
 * @since 0.1.0
 *
 */
 Class BU_Functions {

	/**
	 * Get the variable equivalent to $_SERVER['REQUEST_URI']. This provides a single
	 * location to change URI, if needed.
	 *
	 * @since 0.1.0
	 *
	 * @return string containing the URI which was given in order to access 
	 * this page; for instance, '/index.html'
	 */
	public static function get_server_path_request() {
		
		$uri = htmlspecialchars($_SERVER['REQUEST_URI']);
		return $uri;
	}

	/*
	 * Gets the string value from POST
	 *
	 * @since 0.1.0
	 *
	 * @param string $name name of the variable in POST: $_POST['my_var']
	 * @returns string of the POST data or an empty string
	 */
	public static function get_POST_string($name) {

		$post_string = '';
		
		# If the POST data contains data, use it. Otherwise, return an empty array
		if (isset($_POST[$name]) && $_POST[$name] != "") {
			$post_string = sanitize_text_field($_POST[$name]);
		}

		return $post_string;
	}

	/*
	 * Gets the string value from GET
	 *
	 * @since 0.1.0
	 *
	 * @param string $name name of the variable in GET: $_GET['my_var']
	 * @returns string of the GET data or an empty string
	 */
	public static function get_GET_string($name) {

		$get_string = '';
		
		# If the POST data contains data, use it. Otherwise, return an empty array
		if (isset($_GET[$name]) && $_GET[$name] != "") {
			$get_string = sanitize_text_field($_GET[$name]);
		}

		return $get_string;
	}

	/**
	 * Gets the array from POST
	 *
	 * @since 0.1.0
	 *
	 * @param string $name name of the variable in POST: $_POST['my_var']
	 * @returns array of the POST data or an empty array
	 */
	public static function get_POST_array($name) {

		$post_array = array();
		
		# If the POST data contains data, use it. Otherwise, return an empty array
		if (isset($_POST[$name]) && count($_POST[$name]) > 0) {
		
			# Sanitize the POST values before using them
			$post_array =  BU_Functions::sanitize_array_values($_POST[$name]);
		}

		return $post_array;
	}
	
    /**
     * Uses Wordpress function sanitize_text_field to sanitize any text array values
	 *
	 * @since 0.1.0
	 *
     * @param array $array array text values in an array to sanitize
     * @return array an array containing the same elements that have been sanitized
     */
	public static function sanitize_array_values($array) {

		$sanitized_array = array();
	
		# Loop through each array value and sanitize the value before
		# adding it to the array
	
		for($i = 0; $i < count($array); $i++) {
			$sanitized_array[$i] = sanitize_text_field($array[$i]);			
		}

		return $sanitized_array;	
	}

	/**
	 * Trims the whitespace before and after the value
	 *
	 * @since 0.1.0
	 *
	 * @param array $array to trim the text from
	 * @returns array with the trimmed whitespace
	 */
	 public static function trim_array_values($array) {
	 
		for ($i = 0; $i < count($array); $i++) {
			$array[$i] = trim($array[$i]);
		}
		
		return $array;
	 }
}

?>