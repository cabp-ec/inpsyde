<?php
/**
 * Fired during plugin activation
 *
 * @link       http://carlos-bucheli.com
 * @since      1.0.0
 *
 * @package    CABP_Resource_List
 * @subpackage CABP_Resource_List/includes
 */

namespace Cabp\ResourceList;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    CABP_Resource_List
 * @subpackage CABP_Resource_List/includes
 * @author     Carlos Bucheli <cabp@carlos-bucheli.com>
 */
class CABP_Resource_List_Activator
{

	/**
	 * Activate the plugin.
	 *
	 * Remove rewrite rules and then recreate rewrite rules.
	 *
	 * @since    1.0.0
	 */
	public static function activate()
	{
		flush_rewrite_rules();
	}
}
