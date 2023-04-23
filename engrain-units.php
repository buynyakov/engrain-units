<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/buynyakov/engrain-units
 * @since             1.0.0
 * @package           Engrain_Units
 *
 * @wordpress-plugin
 * Plugin Name:       Engrain Units
 * Plugin URI:        https://github.com/buynyakov/engrain-units
 * Description:       [Assessment Demo] Simple plugin to display list of units.
 * Version:           1.0.0
 * Author:            Andrey Buynyakov
 * Author URI:        https://github.com/buynyakov/engrain-units
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       engrain-units
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'ENGRAIN_UNITS_VERSION', '1.0.0' );


/* 
(Optional)

function activate_engrain_units() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-engrain-units-activator.php';
	Engrain_Units_Activator::activate();
}

function deactivate_engrain_units() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-engrain-units-deactivator.php';
	Engrain_Units_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_engrain_units' );
register_deactivation_hook( __FILE__, 'deactivate_engrain_units' ); 
*/


/**
 * The core plugin class that is used to define
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-engrain-units.php';


/**
 * Begin execution of the plugin.
 *
 * @since    1.0.0
 */
function run_engrain_units() {

	$plugin = new Engrain_Units();
	$plugin->run();

}
run_engrain_units();
