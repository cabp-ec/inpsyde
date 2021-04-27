<?php
/**
 * The plugin bootstrap file.
 *
 * @package CABP_Resource_List
 *
 * Plugin Name: CABP Resource List
 * Plugin URI: https://carlos-bucheli.com
 * Description: Easily create an API resource list for your WordPress site.
 * Version: 1.0
 * Author: Carlos Bucheli
 * Author URI: https://carlos-bucheli.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: cabp-resource-list
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Define.
define( 'CABP_RESOURCE_LIST_NAME', 'CABP Resource List' );
define( 'CABP_RESOURCE_LIST_SLUG', 'cabp-resource-list' );
define( 'CABP_RESOURCE_LIST_SLUG_ADMIN', 'cabp-resource-list-admin' );
define( 'CABP_RESOURCE_LIST_VERSION', '1.0' );
define( 'CABP_RESOURCE_LIST_BASENAME', basename( dirname( __FILE__ ) ) );
define( 'CABP_RESOURCE_LIST_DIR', rtrim( plugin_dir_path( __FILE__ ), '/' ) );
define( 'CABP_RESOURCE_LIST_URL', rtrim( plugin_dir_url( __FILE__ ), '/' ) );
define( 'CABP_RESOURCE_LIST_POST_TYPE_CTA', 'cabp_rlist' );

/**
 * Code that runs during plugin activation.
 * This action is documented in includes/class-cabp-resource-list-activator.php
 */
function activate_cabp_resource_list() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/CABP_Resource_List_Activator.php';
	CABP_Resource_List_Activator::activate();
}

/**
 * Code that runs during plugin deactivation.
 * This action is documented in includes/class-cabp-resource-list-deactivator.php
 */
function deactivate_cabp_resource_list() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/CABP_Resource_List_Deactivator.php';
	CABP_Resource_List_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_cabp_resource_list' );
register_deactivation_hook( __FILE__, 'deactivate_cabp_resource_list' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/CABP_Resource_List.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_cabp_resource_list() {
	$plugin = new CABP_Resource_List();
	$plugin->run();
}

run_cabp_resource_list();
