<?php
/**
 * Plugin Name: TxToIT - Grouped info
 * Description: Register your info only once, display it anywhere, output it like you want
 * Version: 1.0.0
 * Author: Pablo Pacheco
 * Author URI: https://github.com/pablo-sg-pacheco
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: txtoit-grouped-info
 * Domain Path: /languages
 */

if (!function_exists('wp_log')) {
	function wp_log ( $log )  {
		if ( true === WP_DEBUG ) {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) );
			} else {
				error_log( $log );
			}
		}
	}
}

use Pablo_Pacheco\WP_Namespace_Autoloader\WP_Namespace_Autoloader;

// Autoload classes
require_once( "vendor/autoload.php" );
$autoloader = new WP_Namespace_Autoloader( array(
	'directory'        => __DIR__,
	'namespace_prefix' => 'TxToIT_Grouped_Info',
	'classes_dir'      => 'classes',
) );
$autoloader->init();

// Initializes plugin
$plugin = \TxToIT_Grouped_Info\Core::get_instance();
$plugin->set_args(array(
	'plugin_file_path' => __FILE__,
	/*'action_links'     => array(
		array(
			'url'  => admin_url( 'options-general.php?page=file-renaming-on-upload' ),
			'text' => __( 'Settings', 'file-renaming-on-upload' ),
		),
	),
	'translation'      => array(
		'text_domain' => 'file-renaming-on-upload',
	),*/
));
$plugin->init();


