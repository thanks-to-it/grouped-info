<?php
/**
 * TxToIT - Grouped Info - Template
 *
 * @version 1.0.0
 * @since   1.0.0
 * @author  Pablo S G Pacheco
 */

namespace TxToIT_Grouped_Info;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'TxToIT_Grouped_Info\Timber' ) ) {

	class Timber {
		public static $timber;

		public static function setup_timber() {
			if ( ! self::$timber ) {
				self::$timber = new \Timber\Timber();
			}

			$plugin = Core::get_instance();

			// Locations
			if ( ! is_array( \Timber\Timber::$locations ) ) {
				$locations                 = array( \Timber\Timber::$locations );
				\Timber\Timber::$locations = $locations;
			}
			\Timber\Timber::$locations[] = get_stylesheet_directory() . '/txtoit-grouped-info';
			\Timber\Timber::$locations[] = plugin_dir_path( $plugin->file_path ) . 'templates';
		}

		public static function add_timber_filters( $twig ) {
			$twig->addFilter( new \Twig_SimpleFilter( 'filter', array( 'TxToIT_Grouped_Info\Timber', 'filter_array' ) ) );
			$twig->addFilter( new \Twig_SimpleFilter( 'ignore_empty', 'array_filter' ) );

			$twig = apply_filters( 'timber/twig', $twig );
			$twig = apply_filters( 'get_twig', $twig );
			return $twig;
		}

		/**
		 * Filters a list of objects, based on a set of key => value arguments.
		 *
		 * @param        $array
		 * @param        $value
		 * @param string $key
		 *
		 * @return mixed
		 */
		public static function filter_array( $array, $value, $key = 'slug', $operator = 'AND' ) {
			$result = wp_list_filter( $array, array( $key => $value ), $operator );
			if ( is_array( $result ) ) {
				$first_element = reset( $result );
				return $first_element;
			}
			return $array;
		}
	}
}