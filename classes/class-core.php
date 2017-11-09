<?php
/**
 * TxToIT - Grouped Info - Core Class
 *
 * @version 1.0.0
 * @since   1.0.0
 * @author  Pablo S G Pacheco
 */

namespace TxToIT_Grouped_Info;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'TxToIT_Grouped_Info\Core' ) ) {

	class Core extends WP_Plugin {
		public $contact_info;

		public function init() {
			parent::init();
			$this->handle_contact_info();
			$this->handle_output_format();
			$this->handle_timber();
		}

		private function handle_timber() {
			add_action( 'timber/twig/filters', array( 'TxToIT_Grouped_Info\Timber', 'add_timber_filters' ) );
		}

		private function handle_contact_info() {
			// Create CPT
			add_action( 'init', array( 'TxToIT_Grouped_Info\Info_CPT', 'register_post_type' ) );

			// Create Taxonomy
			add_action( 'init', array( 'TxToIT_Grouped_Info\Info_Tax', 'register_taxonomy' ) );

			// Create default Taxonomy terms
			register_activation_hook( Core::get_instance()->file_path, array( 'TxToIT_Grouped_Info\Info_Tax', 'create_default_terms' ) );

			// Create default posts
			register_activation_hook( Core::get_instance()->file_path, array( 'TxToIT_Grouped_Info\Info_CPT', 'create_default_info' ) );

			add_shortcode( 'txit_info', array( 'TxToIT_Grouped_Info\Info_Shortcode', 'get_info_shortcode' ) );
		}

		private function handle_output_format() {
			// Add Format Custom Meta Box
			add_action( 'cmb2_admin_init', array( 'TxToIT_Grouped_Info\Output_Format_CMB', 'add_cmb' ) );

			//add_filter('txit_formats',array('TxToIT_Grouped_Info\Output_Format','load_format_content_from_template'));
		}
	}
}