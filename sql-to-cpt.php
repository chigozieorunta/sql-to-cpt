<?php
/**
 * Plugin Name: SQL To CPT
 * Description: Convert SQL file with table columns to CPT meta fields.
 * Version: 1.0.0
 * Author: Chigozie Orunta
 * Author URI: https://github.com/chigozieorunta/sql-to-cpt
 * Text Domain: stc
 *
 * @package SqlToCpt
 */

// Support for site-level autoloading.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

\SqlToCpt\Plugin::init();
