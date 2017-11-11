<?php
/**
 * TxToIT - Grouped Info - Info Tax
 *
 * @version 1.0.0
 * @since   1.0.0
 * @author  Pablo S G Pacheco
 */

namespace TxToIT_Grouped_Info;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'TxToIT_Grouped_Info\Info_Tax' ) ) {

	class Info_Tax {
		public static $taxonomy = 'txtoit_group';

		public static function register_taxonomy() {
			// Add new taxonomy, make it hierarchical (like Groups)
			$labels = array(
				'name'              => _x( 'Groups', 'taxonomy general name', 'txtoit-grouped-info' ),
				'singular_name'     => _x( 'Group', 'taxonomy singular name', 'txtoit-grouped-info' ),
				'search_items'      => __( 'Search Groups', 'txtoit-grouped-info' ),
				'all_items'         => __( 'All Groups', 'txtoit-grouped-info' ),
				'parent_item'       => __( 'Parent Group', 'txtoit-grouped-info' ),
				'parent_item_colon' => __( 'Parent Group:', 'txtoit-grouped-info' ),
				'edit_item'         => __( 'Edit Group', 'txtoit-grouped-info' ),
				'update_item'       => __( 'Update Group', 'txtoit-grouped-info' ),
				'add_new_item'      => __( 'Add New Group', 'txtoit-grouped-info' ),
				'new_item_name'     => __( 'New Group Name', 'txtoit-grouped-info' ),
				'menu_name'         => __( 'Groups', 'txtoit-grouped-info' ),
			);

			$args = array(
				'hierarchical'      => false,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'group' ),
			);

			register_taxonomy( self::$taxonomy, array( Info_CPT::$post_type ), $args );
		}

		public static function add_dropdown_on_admin() {
			global $typenow;
			global $wp_query;
			if ( $typenow == Info_CPT::$post_type ) {
				$taxonomy          = Info_Tax::$taxonomy;
				$business_taxonomy = get_taxonomy( $taxonomy );
				wp_dropdown_categories( array(
					'show_option_all' => sprintf( __( "Show All %s", 'txtoit-grouped-info' ), $business_taxonomy->label ),
					'taxonomy'        => $taxonomy,
					'name'            => Info_Tax::$taxonomy,
					'value_field'     => 'slug',
					'orderby'         => 'name',
					'selected'        => get_query_var( Info_Tax::$taxonomy ),
					'hierarchical'    => true,
					'depth'           => 3,
					'show_count'      => true,  // This will give a view
					'hide_empty'      => false,   // This will give false positives, i.e. one's not empty related to the other terms. TODO: Fix that
				) );
			}
		}

		public static function create_default_terms() {
			self::register_taxonomy();
			//error_log('create_default_terms');

			if ( term_exists( 'social', self::$taxonomy ) == null ) {
				$response = wp_insert_term(
					__( 'Social', 'txtoit-grouped-info' ),
					self::$taxonomy,
					array(
						'slug' => 'social',
					)
				);
			}

			if ( term_exists( 'address', self::$taxonomy ) == null ) {
				$response = wp_insert_term(
					__( 'Address', 'txtoit-grouped-info' ),
					self::$taxonomy,
					array(
						'slug' => 'address',
					)
				);
			}

			if ( term_exists( 'contact', self::$taxonomy ) == null ) {
				$response = wp_insert_term(
					__( 'Contact', 'txtoit-grouped-info' ),
					self::$taxonomy,
					array(
						'slug' => 'contact',
					)
				);
			}
		}
	}
}