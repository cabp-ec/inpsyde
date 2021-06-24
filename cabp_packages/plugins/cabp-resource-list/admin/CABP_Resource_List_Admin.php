<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://carlos-bucheli.com
 * @since      1.0.0
 *
 * @package    CABP_Resource_List
 * @subpackage CABP_Resource_List/admin
 */

namespace Cabp\ResourceList\Admin;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    CABP_Resource_List
 * @subpackage CABP_Resource_List/admin
 * @author     Carlos Bucheli <cabp@carlos-bucheli.com>
 */
class CABP_Resource_List_Admin {
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	private $rlist_options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of this plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( string $plugin_name, string $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Add plugin option page
	 */
	public function add_admin_page() {
		add_options_page(
			CABP_RESOURCE_LIST_NAME,
			CABP_RESOURCE_LIST_NAME,
			'manage_options', // capability
			CABP_RESOURCE_LIST_SLUG, // menu_slug
			array( $this, 'create_admin_page_callback' ) // function
		);
	}

	/**
	 * Admin page content
	 */
	public function create_admin_page_callback() {
	  $defaults = array(
		  'rlist_protocol' => CABP_RESOURCE_LIST_PROTOCOL,
		  'rlist_api_base' => CABP_RESOURCE_LIST_HOST,
		  'rlist_resource' => CABP_RESOURCE_LIST_RESOURCE,
		  'rlist_detail' => CABP_RESOURCE_LIST_DETAIL,
	  );

		$this->rlist_options = wp_parse_args(get_option('cabp_option'), $defaults);
//		$this->rlist_options = get_option( 'cabp_option' );
	  include_once dirname( __FILE__ ) . '/partials/page_content.php';
	}

	/**
	 * Initialize options
	 */
	public function admin_page_init() {
		$section_id = 'cabp_setting_section';

		register_setting(
			'cabp_option_group', // option_group
			'cabp_option', // option_name
			array( $this, 'options_sanitizer' ) // sanitize_callback
		);

		add_settings_section(
			$section_id, // id
			'General', // title
			array( $this, 'admin_section_info' ), // callback
			CABP_RESOURCE_LIST_SLUG_ADMIN // page
		);

		add_settings_field(
			'rlist_protocol', // id
			'Protocol', // title
			array( $this, 'rlist_protocol_callback' ), // callback
			CABP_RESOURCE_LIST_SLUG_ADMIN, // page
			$section_id // section
		);

		add_settings_field(
			'rlist_api_base', // id
			'API Root Base', // title
			array( $this, 'rlist_api_base_callback' ), // callback
			CABP_RESOURCE_LIST_SLUG_ADMIN, // page
			$section_id // section
		);

		add_settings_field(
			'rlist_resource', // id
			'Resource', // title
			array( $this, 'rlist_resource_callback' ), // callback
			CABP_RESOURCE_LIST_SLUG_ADMIN, // page
			$section_id // section
		);

		add_settings_field(
			'rlist_detail', // id
			'Detail Endpoint', // title
			array( $this, 'rlist_detail_callback' ), // callback
			CABP_RESOURCE_LIST_SLUG_ADMIN, // page
			$section_id // section
		);
	}

	/**
	 * Options Sanitizer
	 *
	 * @param $input
	 *
	 * @return array
	 */
	public function options_sanitizer( $input ) {
		$sanitary_values = array();

		if ( isset( $input['rlist_protocol'] ) ) {
			$sanitary_values['rlist_protocol'] = $input['rlist_protocol'];
		}

		if ( isset( $input['rlist_api_base'] ) ) {
			$sanitary_values['rlist_api_base'] = sanitize_text_field( $input['rlist_api_base'] );
		}

		if ( isset( $input['rlist_resource'] ) ) {
			$sanitary_values['rlist_resource'] = sanitize_text_field( $input['rlist_resource'] );
		}

		if ( isset( $input['rlist_detail'] ) ) {
			$sanitary_values['rlist_detail'] = sanitize_text_field( $input['rlist_detail'] );
		}

		return $sanitary_values;
	}

	/**
	 * Section callback
	 */
	public function admin_section_info() {
	}

	/**
	 * Protocol field content
	 */
	public function rlist_protocol_callback() {
		?> <select id="rlist_protocol" name="cabp_option[rlist_protocol]">
			<?php $selected = ( isset( $this->rlist_options['rlist_protocol'] ) && $this->rlist_options['rlist_protocol'] === 'https' ) ? 'selected' : ''; ?>
        <option value="https" <?php echo $selected; ?>>HTTPS</option>
			<?php $selected = ( isset( $this->rlist_options['rlist_protocol'] ) && $this->rlist_options['rlist_protocol'] === 'http' ) ? 'selected' : ''; ?>
        <option value="http" <?php echo $selected; ?>>HTTP</option>
      </select> <?php
	}

	/**
	 * API Root Base callback
	 */
	public function rlist_api_base_callback() {
		printf(
			'<input class="regular-text" type="text" name="cabp_option[rlist_api_base]" id="rlist_api_base" value="%s">',
			isset( $this->rlist_options['rlist_api_base'] ) ? esc_attr( $this->rlist_options['rlist_api_base'] ) : ''
		);
	}

	/**
	 * API Resource callback
	 */
	public function rlist_resource_callback() {
		printf(
			'<input class="regular-text" type="text" name="cabp_option[rlist_resource]" id="rlist_resource" value="%s">',
			isset( $this->rlist_options['rlist_resource'] ) ? esc_attr( $this->rlist_options['rlist_resource'] ) : ''
		);
	}

	/**
	 * Item detail callback
	 */
	public function rlist_detail_callback() {
		printf(
			'<input class="regular-text" type="text" name="cabp_option[rlist_detail]" id="rlist_detail" value="%s">',
			isset( $this->rlist_options['rlist_detail'] ) ? esc_attr( $this->rlist_options['rlist_detail'] ) : ''
		);
	}
}
