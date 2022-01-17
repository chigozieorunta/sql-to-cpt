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
		add_action( 'admin_menu', [ $this, 'sql_to_cpt_page'] );
	}

	/**
	 * Register a custom menu page.
	 */
	public function sql_to_cpt_page() {
		add_menu_page(
			__( 'SQL To CPT Title', 'textdomain' ),
			'SQL To CPT',
			'manage_options',
			'myplugin/myplugin-admin.php',
			'',
			plugins_url( 'myplugin/images/icon.png' ),
			6
		);
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
