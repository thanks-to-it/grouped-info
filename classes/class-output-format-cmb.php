<?php
/**
 * TxToIT - Grouped Info - Format CMB
 *
 * @version 1.0.0
 * @since   1.0.0
 * @author  Pablo S G Pacheco
 */

namespace TxToIT\Grouped_Info;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'TxToIT\Grouped_Info\Output_Format_CMB' ) ) {

	class Output_Format_CMB {
		public static $cmb_id = 'wpci_format';
		public static $cmb_option_format = 'wpci_format';

		public static function add_cmb() {
			$formats = Output_Format::get_formats();
			$cmb_term = new_cmb2_box( array(
				'id' => self::$cmb_id,
				'title'        => esc_html__( 'Format', 'txtoit-grouped-info' ), // Doesn't output for term boxes
				'object_types' => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
				'taxonomies'   => array( Info_Tax::$taxonomy ), // Tells CMB2 which taxonomies should have these fields
				// 'new_term_section' => true, // Will display in the "Add New Category" section
			) );

			$cmb_term->add_field( array(
				'name'     => esc_html__( 'Output format', 'txtoit-grouped-info' ),
				//'desc'     => esc_html__( 'field format', 'txtoit-grouped-info' ),
				'id'       => self::$cmb_option_format,
				'type'     => 'select',
				'options'  => wp_list_pluck( $formats, 'label', 'id' ),
				'on_front' => false,
			) );
		}
	}
}