<?php
/*
 * The BU_Admin class which controls the WP Burner User admin code
 *	
 * LICENSE: GNU General Public License (GPL) version 2
 *
 * @author     Tony Hetrick
 * @copyright  [2015] [tonyhetrick.com]
 * @license    https://www.gnu.org/licenses/gpl.html
*/

# Wordpress security recommendation
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

// Initialize the plugin
add_action( 'plugins_loaded', create_function( '', '$BU_Admin = new BU_Admin;' ) );

# PHP includes go here. Any HTML includes go in function plugin_options_page()
include(BU_LIB_DIR . '/class-bu-message.php');

/*
 * The main admin class.  
 * Based on the template code from: 
	http://theme.fm/2011/10/how-to-create-tabs-with-the-settings-api-in-wordpress-2590/
	
	To create a new tab: 
		1) Create a new key and assign it to the value of the PHP file: 
			private $abc_admin_key = 'bu-admin-abc'
		2) Duplicate the function that reads: function register_abc_admin()
		3) Rename it and change data
		4) Duplicate the add_action function call in the constructor (this determines the tab order)
		5) Match the function call to the above name
 *
 * @since 0.1.0
 *
 */
class BU_Admin {
	
	# Keys used for the tab data and settings
	private $plugin_label = 'WP Burner User';
	private $plugin_url_slug = '';
	private $create_user_admin_key = 'bu-admin-create-user';
	private $help_admin_key = 'bu-admin-help';
	private $plugin_settings_tabs = array();
	
	/*
	 * Register the actions on init
	 *
	 * @since 0.1.0
	 *
	 */
	function __construct() {
		add_action('admin_init', array(&$this, 'register_create_user_admin'));
		add_action('admin_init', array(&$this, 'register_help_admin'));
		add_action('admin_menu', array(&$this, 'add_admin_menus'));
	}
	
	/*
	 * Registers the tab and appends the key to the tabs array of the object.
	 */
	function register_create_user_admin() {
		$this->plugin_settings_tabs[$this->create_user_admin_key] = 'Create User';
	}
	
	/*
	 * Registers the help settings and appends the key to the tabs 
	 * array of the object.
	 *
	 * @since 0.1.0
	 *
	 */
	function register_help_admin() {
		$this->plugin_settings_tabs[$this->help_admin_key] = 'Help';
	}

	/*
	 * Called during admin_menu, adds an option page under Settings, rendered
	 * using the plugin_options_page method.
	 *
	 * @since 0.1.0
	 *
	 */
	function add_admin_menus() {
		add_options_page(
			$this->plugin_label, 
			$this->plugin_label, 
			'manage_options', 
			$this->plugin_url_slug, 
			array( &$this, 'plugin_options_page' ) );
	}
	
	/*
	 * Plugin Options page rendering goes here, checks
	 * for active tab and replaces key with the related
	 * settings key. Uses the plugin_options_tabs method
	 * to render the tabs.
	 *
	 * @since 0.1.0
	 *
	 */
	function plugin_options_page() {

		$tab = $this->get_current_tab();
		
?> 
		<div class="wrap">
			<?php $this->plugin_options_tabs(); echo "\n"; ?>
			<form method="post" action="options.php">
				<?php wp_nonce_field( 'update-options' ); echo "\n"; ?>
				<?php settings_fields( $tab ); echo "\n"; ?>
				<?php do_settings_sections( $tab ); echo "\n"; ?>
			</form>
		</div>
<?php
		
		// This loads the code for the active tab
		require_once $tab . '.php';

		#--- This is where any common non-php includes for the admin code goes ---#
		include BU_ADMIN_DIR . '/admin-styles.css';
	}
	
	/*
	 * Renders the tabs in the plugin options page
	 *
	 * @since 0.1.0
	 *
	 */
	function plugin_options_tabs() {

		$current_tab = $this->get_current_tab();
?> 
			<h2 class="nav-tab-wrapper">
<?php

# The complete <tr> row
$tab_html_format = <<<EOD
				<a class="nav-tab %s" href="?page=%s&amp;tab=%s">%s</a>

EOD;

		foreach ( $this->plugin_settings_tabs as $tab_key => $tab_caption ) {

			$active = '';

			# Determine if tab_key is the current tab. If true, mark as active 
			# so the contents of the tab will be displayed
			if ($current_tab == $tab_key) {
				$active = 'nav-tab-active';
			}
			
			#Build the tab
			echo sprintf( $tab_html_format, $active, $this->plugin_url_slug, $tab_key, $tab_caption );
		}
?>	
			</h2>
<?php
	}
	
    /**
     * Gets the string value of the current tab. If not set, uses the primary 
	 * admin tab
     * 
     * @return string the value of the current tab or the default tab if not set
     */
	private function get_current_tab() {
	
		$tab = BU_Functions::get_GET_string( 'tab' );
		
		# If no tab is set, use the default tab
		if ( $tab == '' ) {
			$tab = $this->create_user_admin_key;
		}
		
		return $tab;
	}
};
?>