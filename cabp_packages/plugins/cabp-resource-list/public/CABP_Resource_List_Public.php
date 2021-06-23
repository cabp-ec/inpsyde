<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://carlos-bucheli.com
 * @since      1.0.0
 *
 * @package    CABP_Resource_List
 * @subpackage CABP_Resource_List/public
 */

namespace Cabp\ResourceList\_Public;

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    CABP_Resource_List
 * @subpackage CABP_Resource_List/public
 * @author     Carlos Bucheli <info@carlos-bucheli.com>
 */
class CABP_Resource_List_Public {
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

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 *
	 * @param      string $plugin_name The name of the plugin.
	 * @param      string $version The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'wp-jquery-ui-dialog' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		$template_content = file_get_contents( dirname( __FILE__ ) . '/partials/modal_content.php' );
		$template_loading = file_get_contents( dirname( __FILE__ ) . '/partials/modal_content_loading.php' );
		$template_error   = file_get_contents( dirname( __FILE__ ) . '/partials/content_error.php' );

		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_script( 'hogan.js', plugin_dir_url( __FILE__ ) . 'js/hogan-3.0.2.min.js', array(), $this->version, true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/cabp-resource-list-public.js', array( 'jquery' ), $this->version, true );
		wp_localize_script( $this->plugin_name, 'ajax_object', array(
			'ajax_url'         => admin_url( 'admin-ajax.php' ),
			'ajax_action'      => 'rlist_get_detail',
			'ajax_trigger'     => 'a.rlist_detail',
			'modal_id'         => 'cabp_rlist_dialog',
			'template_content' => $template_content,
			'template_loading' => $template_loading,
			'template_error'   => $template_error,
		) );
	}

	/**
	 * Add rewrite(s) for custom endpoint(s)
	 */
	public function add_rewrites() {
		add_rewrite_endpoint( 'cabp', EP_ROOT );
	}

	/**
	 * Plugin public page
	 */
	public function rewrite_content() {
		$items = $this->get_resource();
		include_once dirname( __FILE__ ) . '/partials/page_content.php';
	}

	/**
	 * Get resource details (AJAX response)
	 */
	public function rlist_get_detail() {
		try {
			$options  = get_option( 'cabp_option' );
			$item_id  = intval( $_POST['item_id'] );
			$endpoint = $options['rlist_detail'];
			$protocol = $options['rlist_protocol'];
			$base     = $options['rlist_api_base'];
			$resource = $options['rlist_resource'];
			$url      = "$protocol://$base/$resource/$item_id/$endpoint";

			$data   = $this->get_remote( $url );
			$status = count( $data ) ? 200 : 404;
		} catch ( \Exception $exception ) {
			$debug  = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG;
			$status = 500;
			$data   = ( true === $debug ) ? [
				'code'    => $exception->getCode(),
				'file'    => $exception->getFile(),
				'message' => $exception->getMessage(),
			] : [];

			// TODO: log exception
		}

		echo json_encode( [
			'status' => $status,
			'data'   => $data,
		] );

		wp_die();
	}

	/**
	 * Get resource from remote source
	 * @return mixed
	 */
	private function get_resource() {
		$options = get_option( 'cabp_option' );
		$url     = $options['rlist_protocol'] . '://' . $options['rlist_api_base'] . '/' . $options['rlist_resource'];
		$output  = $this->get_remote( $url );

		return $output;
	}

	/**
	 * Get from remote
	 *
	 * @param string $url
	 * @param bool $as_array
	 *
	 * @return mixed
	 */
	private function get_remote( string $url, bool $as_array = true ) {
		$response = wp_remote_get( $url );
		$body     = $response['body'];

		return $as_array ? json_decode( $body, true ) : $body;
	}
}
