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

namespace Cabp\ResourceList;

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
     * Deactivate the plugin.
     *
     * Remove the options page then remove rewrite rules and then recreate rewrite rules.
     *
     * @since    1.0.0
     */
    public static function deactivate()
    {
	    delete_option('cabp_option');
	    flush_rewrite_rules();
    }
}
