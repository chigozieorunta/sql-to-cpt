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
