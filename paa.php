<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.facebook.com/geckowebdev.ml/
 * @since             1.0.0
 * @package           Paa
 *
 * @wordpress-plugin
 * Plugin Name:       PogoAppApi
 * Plugin URI:        https://shinytarts.com/
 * Description:       This plugin play as an REST api reciever for pokemon accounts and also create the tables that holds the accounts.
 * Version:           1.0.0
 * Author:            Younes Arab nedjadi
 * Author URI:        https://www.facebook.com/geckowebdev.ml/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       paa
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Defined Secret kies 
 */



//\www/wp-content/plugins/paa/
$plugin_dir = ABSPATH . 'wp-content/plugins/paa/';


/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PAA_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-paa-activator.php
 */
function activate_paa() {
	
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-paa-activator.php';
	Paa_Activator::activate();

	
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-paa-deactivator.php
 */
function deactivate_paa() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-paa-deactivator.php';
	Paa_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_paa' );
register_deactivation_hook( __FILE__, 'deactivate_paa' );

/**
* FAKER FOR GENERATING ACCOUNT NAMES
*/
require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-paa.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_paa() {

	$plugin = new Paa();
	$plugin->run();

}
run_paa();





	
	



/* add_shortcode('testforplug', 'dbnames_shortcode');
function dbnames_shortcode( $atts = [], $content = null) {
	global $result;
	$content = $result;
    var_dump($content);
} */