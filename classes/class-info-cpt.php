<?php
/**
 * TxToIT - Grouped Info - Info Object
 *
 * @version 1.0.0
 * @since   1.0.0
 * @author  Pablo S G Pacheco
 */

namespace TxToIT_Grouped_Info;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'TxToIT_Grouped_Info\Info_CPT' ) ) {

	class Info_CPT {
		public static $post_type = 'txtoit_info';

		public static function register_post_type() {
			$labels = array(
				'name'               => _x( 'Info', 'post type general name', 'txtoit-grouped-info' ),
				'singular_name'      => _x( 'Info', 'post type singular name', 'txtoit-grouped-info' ),
				'menu_name'          => _x( 'Info', 'admin menu', 'txtoit-grouped-info' ),
				'name_admin_bar'     => _x( 'Info', 'add new on admin bar', 'txtoit-grouped-info' ),
				'add_new'            => _x( 'Add New', 'Info', 'txtoit-grouped-info' ),
				'add_new_item'       => __( 'Add New Info', 'txtoit-grouped-info' ),
				'new_item'           => __( 'New Info', 'txtoit-grouped-info' ),
				'edit_item'          => __( 'Edit Info', 'txtoit-grouped-info' ),
				'view_item'          => __( 'View Info', 'txtoit-grouped-info' ),
				'all_items'          => __( 'All Info', 'txtoit-grouped-info' ),
				'search_items'       => __( 'Search Info', 'txtoit-grouped-info' ),
				'parent_item_colon'  => __( 'Parent Info:', 'txtoit-grouped-info' ),
				'not_found'          => __( 'No Info found.', 'txtoit-grouped-info' ),
				'not_found_in_trash' => __( 'No Info found in Trash.', 'txtoit-grouped-info' )
			);

			$args = array(
				'labels'             => $labels,
				'description'        => __( 'Contact info.', 'txtoit-grouped-info' ),
				'public'             => true,
				'menu_icon'          => 'dashicons-editor-ul', //'dashicons-info'
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => 'Info' ),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'hierarchical'       => false,
				'menu_position'      => null,
				'supports'           => array( 'title', 'editor' )
				//'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
			);
			register_post_type( self::$post_type, $args );
		}

		public static function create_default_info() {
			$term_social  = get_term_by( 'slug', 'social', Info_Tax::$taxonomy );
			$term_address = get_term_by( 'slug', 'address', Info_Tax::$taxonomy );
			$term_contact = get_term_by( 'slug', 'contact', Info_Tax::$taxonomy );

			$posts_to_add = array(

				// Social
				array(
					'post_type'   => self::$post_type,
					'post_title'  => 'Facebook',
					'post_status' => 'publish',
					'tax_input'   => array(
						Info_Tax::$taxonomy => array( $term_social->term_id )
					)
				),
				array(
					'post_type'   => self::$post_type,
					'post_title'  => 'Twitter',
					'post_status' => 'publish',
					'tax_input'   => array(
						Info_Tax::$taxonomy => array( $term_social->term_id )
					)
				),
				array(
					'post_type'   => self::$post_type,
					'post_title'  => 'Google Plus',
					'post_status' => 'publish',
					'tax_input'   => array(
						Info_Tax::$taxonomy => array( $term_social->term_id )
					)
				),

				// Address
				array(
					'post_type'   => self::$post_type,
					'post_title'  => __( 'Country', 'txtoit-grouped-info' ),
					'post_status' => 'publish',
					'tax_input'   => array(
						Info_Tax::$taxonomy => array( $term_address->term_id )
					)
				),
				array(
					'post_type'   => self::$post_type,
					'post_title'  => __( 'State', 'txtoit-grouped-info' ),
					'post_status' => 'publish',
					'tax_input'   => array(
						Info_Tax::$taxonomy => array( $term_address->term_id )
					)
				),
				array(
					'post_type'   => self::$post_type,
					'post_title'  => __( 'City', 'txtoit-grouped-info' ),
					'post_status' => 'publish',
					'tax_input'   => array(
						Info_Tax::$taxonomy => array( $term_address->term_id )
					)
				),
				array(
					'post_type'   => self::$post_type,
					'post_title'  => __( 'Street', 'txtoit-grouped-info' ),
					'post_status' => 'publish',
					'tax_input'   => array(
						Info_Tax::$taxonomy => array( $term_address->term_id )
					)
				),
				array(
					'post_type'   => self::$post_type,
					'post_title'  => __( 'Zip code', 'txtoit-grouped-info' ),
					'post_status' => 'publish',
					'tax_input'   => array(
						Info_Tax::$taxonomy => array( $term_address->term_id )
					)
				),

				// Contact
				array(
					'post_type'   => self::$post_type,
					'post_title'  => __( 'Phone 1', 'txtoit-grouped-info' ),
					'post_status' => 'publish',
					'tax_input'   => array(
						Info_Tax::$taxonomy => array( $term_contact->term_id )
					)
				),
				array(
					'post_type'   => self::$post_type,
					'post_title'  => __( 'Phone 2', 'txtoit-grouped-info' ),
					'post_status' => 'publish',
					'tax_input'   => array(
						Info_Tax::$taxonomy => array( $term_contact->term_id )
					)
				),
				array(
					'post_type'   => self::$post_type,
					'post_title'  => __( 'Email', 'txtoit-grouped-info' ),
					'post_status' => 'publish',
					'tax_input'   => array(
						Info_Tax::$taxonomy => array( $term_contact->term_id )
					)
				),
			);

			foreach ( $posts_to_add as $post_to_add ) {
				$post = get_posts( array(
					'post_type' => $post_to_add['post_type'],
					'title'     => $post_to_add['post_title']
				) );
				if ( ! is_array( $post ) || count( $post ) == 0 ) {
					wp_insert_post( $post_to_add );
				}
			}
		}
	}
}