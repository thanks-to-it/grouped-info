<?php
/**
 * TxToIT - Grouped Info - Info Shortcode
 *
 * @version 1.0.0
 * @since   1.0.0
 * @author  Pablo S G Pacheco
 */

namespace TxToIT_Grouped_Info;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'TxToIT_Grouped_Info\Info_Shortcode' ) ) {

	class Info_Shortcode {

		private static function create_tax_query_param( $args ) {
			$tax = Info_Tax::$taxonomy;

			if ( ! empty( $args['group'] ) ) {
				$args['tax_query'] =
					array(
						array(
							'taxonomy' => $tax,
							'field'    => 'slug',
							'terms'    => $args['group'],
						),
					);
			}

			return $args;
		}

		private static function get_format_id( $original_atts, $args ) {
			$tax = Info_Tax::$taxonomy;

			if ( ! empty( $args['group'] ) ) {
				$term      = get_term_by( 'slug', $args['group'], $tax );
				$format_id = get_term_meta( $term->term_id, Output_Format_CMB::$cmb_option_format, true );
				$format_id = ! empty( $original_atts['format'] ) ? $original_atts['format'] : $format_id;
			} else {
				$format_id = $args['format'];
			}

			return $format_id;
		}

		public static function get_info_shortcode( $original_atts ) {
			$args = shortcode_atts( array(
				'format' => 'list',
				'name'   => null,
				'group'  => null,
			), $original_atts, 'txit_info' );

			// Cancel
			if (
				( empty( $args['name'] ) && empty( $args['group'] ) ) ||
				( ! empty( $args['name'] ) && ! empty( $args['group'] ) )
			) {
				return '';
			}

			$args['post_type'] = Info_CPT::$post_type;
			$args['order']     = 'asc';
			$args['orderby']   = 'menu_order title';
			$format_id         = self::get_format_id( $original_atts, $args );

			// Create tax query param
			$args = self::create_tax_query_param( $args );

			// Format
			$format = Output_Format::get_format_by_id( $format_id );
			if ( $format === false ) {
				return;
			}

			if ( $format['template_from'] == 'twig_file' || empty( $format['template_from'] ) ) {
				$source = ! empty( $format['source'] ) ? $format['source'] : "format-{$format['id']}.twig";
				\TxToIT_Grouped_Info\Timber::setup_timber();
				$context['posts'] = \Timber::get_posts( $args );
				$context          = apply_filters( 'txit_timber_context', $context, $format );
				$source           = \Timber\Timber::compile( $source, $context );
				return $source;
			}
		}
	}
}