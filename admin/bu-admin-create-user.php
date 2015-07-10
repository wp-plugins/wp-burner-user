<?php
/*
 * Add a new burner user to Wordpress
 *	
 * LICENSE: GNU General Public License (GPL) version 2
 *
 * @author     Tony Hetrick
 * @copyright  [2015] [tonyhetrick.com]
 * @license    https://www.gnu.org/licenses/gpl.html
*/

# Wordpress security recommendation
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

?>

<div class="wrap">
	<h2>Create Burner User</h2>
	<p>Create a brand new user as a <b>subscriber</b> and add them to this site without the typical WordPress requirements. By default, the user is generated from anonymous data.</p>
	<h3>Form Information</h3>
	<p>All fields are optional.</p>
	<ul>
		<li><b>Username:</b> If blank, and random string of characters becomes the user name</li>
		<li><b>E-mail:</b> If blank, the email becomes <i>username@example.com</i> </li>
		<li><b>First Name:</b> If blank, no first name is assigned </li>
		<li><b>Last Name:</b> If blank, no last name is assigned </li>
		<li><b>Password:</b> If blank, a random password is assigned </li>
	</ul>	
	<hr />

<?php

# Scan for POST values
$form_submit = BU_Functions::get_POST_string( 'new_user_submit' );

# If the form has been submitted, process the request
if( $form_submit == 'Y' ) {
	bu_add_burner_user();
}

?>
	
	<h3>Add Burner User</h3>
	<form name="createuser_form" method="post" action="<?php echo BU_Functions::get_server_path_request(); ?>">
		<input type="hidden" name="new_user_submit" value="Y">
		<table class="form-table">
			<tbody><tr class="form-field">
				<th scope="row"><label for="user_login">Username <span class="description"></span></label></th>
				<td><input name="user_login" type="text" id="user_login" value="" aria-required="true"></td>
			</tr>
			<tr class="form-field">
				<th scope="row"><label for="email">E-mail <span class="description"></span></label></th>
				<td><input name="email" type="email" id="email" value=""></td>
			</tr>
			<tr class="form-field">
				<th scope="row"><label for="first_name">First Name </label></th>
				<td><input name="first_name" type="text" id="first_name" value=""></td>
			</tr>
			<tr class="form-field">
				<th scope="row"><label for="last_name">Last Name </label></th>
				<td><input name="last_name" type="text" id="last_name" value=""></td>
			</tr>
			<tr class="form-field">
				<th scope="row"><label for="pass1">Password <span class="description"></span></label></th>
				<td>
					<input name="password" type="password" id="password" value="" autocomplete="off">
				</td>
			</tr>
			</tbody>
		</table>
		<p class="submit"><input type="submit" name="createuser" id="createusersub" class="button button-primary" value="Create Burner User"></p>
		</form>
</div>
<hr />

<?php

/**
  * Adds a user to WordPress. If POST values are all blank, auto generates a user
  *
  * @since 0.1.0
  *
  */
function bu_add_burner_user() {

	global $bu_message;

	$username = trim( BU_Functions::get_POST_string( 'user_login' ) );
	$email = trim( BU_Functions::get_POST_string( 'email' ));
	$password = trim( BU_Functions::get_POST_string( 'password' ) );
	$first_name = trim( BU_Functions::get_POST_string( 'first_name' ) );
	$last_name = trim( BU_Functions::get_POST_string( 'last_name' ) );
	
	# If no user, generate a random user name
	if ( $username == '' ) {
		$username = wp_generate_password( $length=12, $include_standard_special_chars=false );
	}
	
	# If no email address, use username@example.com
	if ( $email == '' ) {
		$email = $username . '@example.com';
	}
	
	#Verify the user doesn't already exist
	$user_id = username_exists( $username );

	# If user data is unique, add it
	if ( !$user_id and email_exists( $email ) == false ) {

		# If password is blank, create a random password
		if ( $password == '' ) {
			$password = wp_generate_password( $length=12, $include_standard_special_chars=false );
		}

		# Create the user, get the ID, and update the profile with user data
		$user_id = wp_create_user( $username, $password, $email );
		bu_modify_burner_profile( $user_id, $first_name, $last_name );
		
		# Issue the message
		$message = __( "Successfully created user '$username'. Password: $password" );
		$bu_message->print_message( $message, $bu_message->success );
		
	} else {
		# User already exists. Issue message.
		$message = __( "User '$username' already exists." );
		$bu_message->print_message( $message, $bu_message->warning );
	}
}

 
/**
  * Adds the first and last name to the profile
  *
  * @since 0.1.0
  * 
  * @param int $user_id id of the user
  * @param string $first_name first name of the user
  * @param string $last_name last name of the user
  *
  */
function bu_modify_burner_profile( $user_id, $first_name, $last_name ) {

	global $bu_message;

	$user_id = wp_update_user( array( 	'ID' => $user_id, 
										'first_name' => $first_name, 
										'last_name' => $last_name ) );

	if ( is_wp_error( $user_id ) ) {
		$message = __("Oops...something went wrong adding the first and last 
					  names. Please use the users settings panel to add this 
					  user information.");
		$bu_message->print_message($message, $bu_message->error);
	} 
}

?>