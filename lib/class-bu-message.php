<?php
/*
 * Displays messages in the admin panel
 *	
 * LICENSE: GNU General Public License (GPL) version 2
 *
 * @author     Tony Hetrick
 * @copyright  [2015] [tonyhetrick.com]
 * @license    https://www.gnu.org/licenses/gpl.html
*/

# Wordpress security recommendation
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/*
  Example of class use: 
 	$bu_message = new BU_Message();
 	$bu_message->print($message, $bu_message->information);
-OR-
 	global $bu_message;
 	$bu_message->print($message, $bu_message->information);
*/

/**
 * This class writes messages to the admin panel. 
 *
 * @since 0.1.0
 *
 */
Class BU_Message {

	/**
	 * The text for the information message
	 *
	 * @since 0.1.0
	 * @var string $information
	 */
	public $information = "information";
	/**
	 * The text for the error message
	 *
	 * @since 0.1.0
	 * @var string $error
	 */
	public $error = "error";
	/**
	 * The text for the warning message
	 *
	 * @since 0.1.0
	 * @var string $warning
	 */
	public $warning = "warning";
	/**
	 * The text for the success message
	 *
	 * @since 0.1.0
	 * @var string $success
	 */
	public $success = "success";
	
	/*
	 * Prints a message to the screen in HTML format
	 *
	 * @since 0.1.0
	 *
	 * @param string $message Message to display
	 * @param string $type Type of message to display
	*/
	function print_message( $message, $type = "" ) {
		
		if ( $type == "" ) {
			$type = $this->information;
		}
	
	?>
		<p class="message <?php echo $type; ?>"> <?php echo $message; ?></p>
	<?php
	}
}
	# The global instance
	$bu_message = new BU_Message();

?>