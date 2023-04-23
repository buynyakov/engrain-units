<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/buynyakov/engrain-units
 * @since      1.0.0
 *
 * @package    Engrain_Units
 * @subpackage Engrain_Units/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Engrain_Units
 * @subpackage Engrain_Units/includes
 * @author     Andrey Buynyakov <buynyakov@gmail.com>
 */
class Engrain_Units_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'engrain-units',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
