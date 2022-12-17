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
 * @since             0.0.1
 * @package           BaseCRM
 *
 * @wordpress-plugin
 * Plugin Name:       Base CRM
 * Plugin URI:        https://thejohnson.group/
 * Description:       Base CRM is a Lead Management plugin that provides a front-end area for website members to upload referrals while out in the field.
 * Version:           0.0.1
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
 * Start at version 0.0.1 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BaseCRM_VERSION', '0.0.1' );
define( 'BaseCRM_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'BaseCRM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

global $wpdb;
$prefix = $wpdb->prefix;
define( 'BaseCRM_LEADS_TABLE', $prefix . 'base_crm_leads' );
define( 'BaseCRM_LEADS_META_TABLE', $prefix . 'base_crm_leads_meta' );
define( 'BaseCRM_LOGS_TABLE', $prefix . 'base_crm_logs' );
define( 'BaseCRM_APPOINTMENTS_TABLE', $prefix . 'base_crm_appointments' );


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-base-crm-activator.php
 */
function init_BaseCRM() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-base-crm-activator.php';
	BaseCRM_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-base-crm-deactivator.php
 */
function deactivate_BaseCRM() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-base-crm-deactivator.php';
	BaseCRM_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'init_BaseCRM' );
register_deactivation_hook( __FILE__, 'deactivate_BaseCRM' );

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
 * @since    0.0.1
 */
function run_BaseCRM() {

	$plugin = new BaseCRM();
	$plugin->run();

}
run_BaseCRM();
