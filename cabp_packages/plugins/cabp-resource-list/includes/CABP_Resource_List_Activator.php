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
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate()
	{
		flush_rewrite_rules();
	}
}
