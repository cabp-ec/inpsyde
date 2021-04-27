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
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        $this->plugin_name = CABP_RESOURCE_LIST_SLUG;
        $this->version = CABP_RESOURCE_LIST_VERSION;

        $this->load_dependencies();
        $this->set_locale();
        $this->plugin_admin = new CABP_Resource_List_Admin($this->get_plugin_name(), $this->get_version());
        $this->plugin_public = new CABP_Resource_List_Public($this->get_plugin_name(), $this->get_version());
        $this->define_admin_hooks();
        $this->define_public_hooks();
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - CABP_Resource_List_Loader. Orchestrates the hooks of the plugin.
     * - CABP_Resource_List_i18n. Defines internationalization functionality.
     * - CABP_Resource_List_Admin. Defines all hooks for the admin area.
     * - CABP_Resource_List_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/CABP_Resource_List_Loader.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/CABP_Resource_List_i18n.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/CABP_Resource_List_Admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/CABP_Resource_List_Public.php';

        $this->loader = new CABP_Resource_List_Loader();
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
        $plugin_i18n = new CABP_Resource_List_i18n();
        $plugin_i18n->set_domain($this->get_plugin_name());
        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
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
        $plugin_admin = $this->plugin_admin;

        // Add settings page.
	    $this->loader->add_action('admin_menu', $plugin_admin, 'add_admin_page');
	    $this->loader->add_action('admin_init', $plugin_admin, 'admin_page_init');
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
        $plugin_public = $this->plugin_public;

	    // Add endpoint
	    $this->loader->add_action('init', $plugin_public, 'add_rewrites');
	    $this->loader->add_action('template_redirect', $plugin_public, 'rewrite_content');

	    // Enqueue CSS
	    $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');

	    // Enqueue JS
	    $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	    // AJAX
	    if ( is_admin() ) {
		    $this->loader->add_action( 'wp_ajax_rlist_get_detail', $plugin_public, 'rlist_get_detail' );
		    $this->loader->add_action( 'wp_ajax_nopriv_rlist_get_detail', $plugin_public, 'rlist_get_detail' );
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
