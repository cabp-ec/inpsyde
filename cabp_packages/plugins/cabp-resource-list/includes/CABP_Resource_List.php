<?php
/**
 * The file that defines the core plugin class.
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://carlos-bucheli.com
 * @since      1.0.0
 *
 * @package    CABP_Resource_List
 * @subpackage CABP_Resource_List/includes
 */

namespace Cabp\ResourceList;

use Cabp\ResourceList\Admin\CABP_Resource_List_Admin;
use Cabp\ResourceList\_Public\CABP_Resource_List_Public;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    CABP_Resource_List
 * @subpackage CABP_Resource_List/includes
 * @author     Carlos Bucheli <cabp@carlos-bucheli.com>
 */
class CABP_Resource_List
{
    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      CABP_Resource_List_Loader $loader Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $plugin_name The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version The current version of the plugin.
     */
    protected $version;

    /**
     * Instance of plugin admin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $plugin_admin The object of plugin admin class.
     */
    protected $plugin_admin;

    /**
     * Instance of plugin public.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $plugin_public The object of plugin public class.
     */
    protected $plugin_public;

	/**
	 * @var CABP_Resource_List_Admin
	 */
	private $admin;

	/**
	 * @var CABP_Resource_List_Public
	 */
	private $public;

	/**
	 * @var CABP_Resource_List_i18n
	 */
	private $i_18_n;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 *
	 * @param CABP_Resource_List_Loader $loader
	 * @param CABP_Resource_List_i18n $i_18_n
	 * @param CABP_Resource_List_Admin $admin
	 * @param CABP_Resource_List_Public $public
	 */
    public function __construct(
	    CABP_Resource_List_Loader $loader,
	    CABP_Resource_List_i18n $i_18_n,
    	CABP_Resource_List_Admin $admin,
	    CABP_Resource_List_Public $public
    )
    {
	    $this->loader = $loader;
	    $this->i_18_n = $i_18_n;
	    $this->admin = $admin;
	    $this->public = $public;

	    $this->plugin_name = CABP_RESOURCE_LIST_SLUG;
	    $this->version = CABP_RESOURCE_LIST_VERSION;

        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the CABP_Resource_List_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {
        $this->i_18_n->set_domain($this->get_plugin_name());
        $this->loader->add_action('plugins_loaded', $this->i_18_n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {
        // Add settings page.
	    $this->loader->add_action('admin_menu', $this->admin, 'add_admin_page');
	    $this->loader->add_action('admin_init', $this->admin, 'admin_page_init');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {
	    // Add endpoint
	    $this->loader->add_action('init', $this->public, 'add_rewrites');
	    $this->loader->add_action('template_redirect', $this->public, 'rewrite_content');

	    // Enqueue CSS
	    $this->loader->add_action('wp_enqueue_scripts', $this->public, 'enqueue_styles');

	    // Enqueue JS
	    $this->loader->add_action( 'wp_enqueue_scripts', $this->public, 'enqueue_scripts' );

	    // AJAX
	    if ( is_admin() ) {
		    $this->loader->add_action( 'wp_ajax_rlist_get_detail', $this->public, 'rlist_get_detail' );
		    $this->loader->add_action( 'wp_ajax_nopriv_rlist_get_detail', $this->public, 'rlist_get_detail' );
	    }
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    CABP_Resource_List_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }
}
