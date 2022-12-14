<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/kalamalahala
 * @since             1.0.0
 * @package           Base_Crm
 *
 * @wordpress-plugin
 * Plugin Name:       Base CRM
 * Plugin URI:        https://thejohnson.group/
 * Description:       Base CRM is a Lead Management plugin that provides a front-end area for website members to upload referrals while out in the field.
 * Version:           1.0.0
 * Author:            Tyler Karle
 * Author URI:        https://github.com/kalamalahala
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       base-crm
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BASE_CRM_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-base-crm-activator.php
 */
function activate_base_crm() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-base-crm-activator.php';
	Base_Crm_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-base-crm-deactivator.php
 */
function deactivate_base_crm() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-base-crm-deactivator.php';
	Base_Crm_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_base_crm' );
register_deactivation_hook( __FILE__, 'deactivate_base_crm' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-base-crm.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_base_crm() {

	$plugin = new Base_Crm();
	$plugin->run();

}
run_base_crm();
