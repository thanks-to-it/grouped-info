<?php
/**
 * TxToIT - Grouped Info - Format
 *
 * @version 1.0.0
 * @since   1.0.0
 * @author  Pablo S G Pacheco
 */

namespace TxToIT\Grouped_Info;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'TxToIT\Grouped_Info\Output_Format' ) ) {
	class Output_Format {
		public static $formats = array();

		public static function get_formats() {
			$formats       = array(
				array(
					'id'            => 'list',
					'label'         => 'List',
					'template_from' => 'twig_file',
				),
				array(
					'id'            => 'google_maps',
					'label'         => 'Google maps',
					'template_from' => 'twig_file',
				),
				array(
					'id'            => 'full_address',
					'label'         => 'Full Address',
					'template_from' => 'twig_file',
				),
				array(
					'id'            => 'list_fa',
					'label'         => 'List - Font Awesome',
					'template_from' => 'twig_file',
				),
				array(
					'id'            => 'comma',
					'label'         => 'Comma Separated',
					'template_from' => 'twig_file',
				),
				array(
					'id'            => 'info',
					'label'         => 'Simple info',
					'template_from' => 'twig_file',
				),
			);
			self::$formats = apply_filters( 'txit_formats', $formats );

			// Sort formats
			usort( self::$formats, function ( $a, $b ) {
				return strcmp( $a["label"], $b["label"] );
			} );

			return self::$formats;
		}

		public static function get_format_by_id( $format_id ) {
			$formats          = self::get_formats();
			$formats_filtered = wp_list_filter( $formats, array( 'id' => $format_id ) );
			if (
				! is_array( $formats_filtered ) ||
				count( $formats_filtered ) == 0 ||
				empty( reset( $formats_filtered ) )
			) {
				return false;
			}

			$format = reset( $formats_filtered );
			return $format;
		}

	}
}