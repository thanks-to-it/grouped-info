<?php
/**
 * TxToIT - Grouped Info - Template
 *
 * @version 1.0.0
 * @since   1.0.0
 * @author  Pablo S G Pacheco
 */

namespace TxToIT\Grouped_Info;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'TxToIT\Grouped_Info\Template' ) ) {

	class Template {
		/**
		 * Gets other templates (e.g. product attributes) passing attributes and including the file.
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 * @access  public
		 *
		 * @param string $template_name
		 * @param array  $args          (default: array())
		 * @param string $template_path (default: '')
		 * @param string $default_path  (default: '')
		 */
		public static function get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
			$args = apply_filters( 'txit_get_template_params', $args, $template_name, $template_path, $default_path );

			if ( ! empty( $args ) && is_array( $args ) ) {
				extract( $args );
			}

			$located = self::locate_template( $template_name, $template_path, $default_path );

			if ( ! file_exists( $located ) ) {
				//die( __FUNCTION__, sprintf( __( '%s does not exist.', 'facebook-account-kit-login-for-wordpress' ), '<code>' . $located . '</code>' ), '2.1' );
				return;
			}

			// Allow 3rd party plugin filter template file from their plugin.
			$located = apply_filters( 'txit_get_template', $located, $template_name, $args, $template_path, $default_path );

			do_action( 'txit_before_template_part', $template_name, $template_path, $located, $args );

			include( $located );

			do_action( 'txit_after_template_part', $template_name, $template_path, $located, $args );
		}

		/**
		 * Locates a template and return the path for inclusion.
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 * This is the load order:
		 *
		 *        yourtheme        /    $template_path    /    $template_name
		 *        yourtheme        /    $template_name
		 *        $default_path    /    $template_name
		 *
		 * @access  public
		 *
		 * @param string $template_name
		 * @param string $template_path (default: '')
		 * @param string $default_path  (default: '')
		 *
		 * @return string
		 */
		public static function locate_template( $template_name, $template_path = '', $default_path = '' ) {
			$plugin = Core::get_instance();

			if ( ! $template_path ) {
				$template_path = apply_filters( 'txit_template_path', dirname( $plugin->file_path ) );
			}

			if ( ! $default_path ) {
				$default_path = apply_filters( 'txit_default_path', untrailingslashit( $plugin->dir ) . '/templates/' );
			}

			// Look within passed path within the theme - this is priority.
			$template = locate_template(
				array(
					trailingslashit( $template_path ) . $template_name,
					$template_name,
				)
			);

			// Get default template/
			if ( ! $template ) {
				$template = $default_path . $template_name;
			}

			// Return what we found.
			return apply_filters( 'txit_locate_template', $template, $template_name, $template_path );
		}

	}
}