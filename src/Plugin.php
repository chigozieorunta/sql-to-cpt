<?php
/**
 * Plugin Class
 *
 * @package SqlToCpt
 */

namespace SqlToCpt;

/**
 * Plugin entry point
 */
class Plugin {

	/**
	 * Plugin's singleton instance
	 *
	 * @var object
	 */
	private static $instance;

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'sql_to_cpt_page' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'sql_to_cpt_style' ] );
	}

	/**
	 * Register a custom menu page.
	 */
	public function sql_to_cpt_page() {
		add_menu_page(
			__( 'SQL To CPT', 'stc' ),
			__( 'SQL To CPT', 'stc' ),
			'manage_options',
			'sql-to-cpt',
			[ $this, 'sql_to_cpt_html' ],
			'dashicons-database'
		);
	}

	/**
	 * Display HTML for menu page
	 */
	public function sql_to_cpt_html() {
		ob_start();
		readfile( __DIR__ . '/../sql-to-cpt.html' );
	}

	/**
	 * Custom styling for menu page
	 *
	 * @return void
	 */
	public function sql_to_cpt_style() {
		wp_enqueue_style( 'sql-to-cpt', plugin_dir_url( __FILE__ ) . '../assets/dist/css/plugin.css' );
	}

	/**
	 * Plugin Entry point based on Singleton
	 *
	 * @return Plugin $plugin Instance of the plugin abstraction.
	 */
	public static function init() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
}
