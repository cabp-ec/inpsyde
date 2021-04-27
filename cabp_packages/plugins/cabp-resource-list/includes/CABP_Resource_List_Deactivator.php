<?php
/**
 * Fired during plugin deactivation
 *
 * @link       http://carlos-bucheli.com
 * @since      1.0.0
 *
 * @package    CABP_Resource_List
 * @subpackage CABP_Resource_List/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    CABP_Resource_List
 * @subpackage CABP_Resource_List/includes
 * @author     Carlos Bucheli <cabp@carlos-bucheli.com>
 */
class CABP_Resource_List_Deactivator
{

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function deactivate()
    {
	    delete_option('cabp_option');
	    flush_rewrite_rules();
    }
}
