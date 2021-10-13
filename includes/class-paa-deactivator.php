<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://www.facebook.com/geckowebdev.ml/
 * @since      1.0.0
 *
 * @package    Paa
 * @subpackage Paa/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Paa
 * @subpackage Paa/includes
 * @author     Younes Arab nedjadi <younesheissenmann@gmail.com>
 */
class Paa_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
	
	// Clear the permalinks	
	flush_rewrite_rules();
	}

}
