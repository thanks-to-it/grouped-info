<?php
/**
 * TxToIT - Grouped Info - Wp Plugin
 *
 * @version 1.0.0
 * @since   1.0.0
 * @author  Pablo S G Pacheco
 */

namespace TxToIT\Grouped_Info;


if ( ! class_exists( 'TxToIT\Grouped_Info\WP_Plugin' ) ) {

	class WP_Plugin{

		public $basename;
		public $dir_url;
		public $dir;
		public $args;
		public $file_path;


		protected static $instance = null;


		protected function __clone() {
			//Me not like clones! Me smash clones!
		}

		/**
		 * @return self
		 */
		public static function get_instance() {
			if ( ! isset( static::$instance ) ) {
				static::$instance = new static;
			}

			return static::$instance;
		}


		/**
		 * Constructor.
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		protected function __construct() {

		}




		/**
		 * Setups the plugin (translation, action links, etc)
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		protected function setup() {
			$plugin_file_path = $this->file_path = $this->args['plugin_file_path'];
			$this->basename = plugin_basename( $plugin_file_path );
			$this->dir_url = plugin_dir_url( $plugin_file_path );
			$this->dir = untrailingslashit( plugin_dir_path( $plugin_file_path ) ) . DIRECTORY_SEPARATOR;

			add_filter( 'plugin_action_links_' . $this->basename, array( $this, 'action_links' ) );
			add_action( 'init', array( $this, 'handle_localization' ) );


		}

		/**
		 * Initializes the plugin.
		 *
		 * Should be called after the set_args() method
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 *
		 * @param array $args
		 */
		public function init() {
			// Get plugin args
			$args = $this->args;

			// Setups the plugin (translation, action links, etc)
			$this->setup();
		}

		/**
		 * Called when plugin is enabled
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 *
		 */
		public static function on_plugin_activation() {

		}

		/**
		 * Handles plugin localization
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 */
		public function handle_localization() {
			$args        = $this->args;
			$text_domain = sanitize_text_field( $args['translation']['text_domain'] );
			$locale      = apply_filters( 'plugin_locale', get_locale(), $text_domain );
			load_textdomain( $text_domain, WP_LANG_DIR . dirname( $this->basename ) . $text_domain . '-' . $locale . '.mo' );
			load_plugin_textdomain( $text_domain, false, dirname( $this->basename ) . '/' . $args['translation']['folder'] . '/' );
		}

		/**
		 * Add action links to plugins page
		 *
		 * @param $links
		 *
		 * @return array
		 */
		function action_links( $links ) {
			$args         = $this->args;
			$action_links = $args['action_links'];
			$custom_links = array();

			foreach ( $action_links as $action_link ) {
				if (
					isset( $action_link['url'] ) && ! empty( $action_link['url'] ) &&
					isset( $action_link['text'] ) && ! empty( $action_link['text'] )
				) {
					$url            = sanitize_text_field( $action_link['url'] );
					$text           = sanitize_text_field( $action_link['text'] );
					$custom_links[] = '<a href="' . esc_url( $url ) . '">' . esc_html( $text ) . '</a>';
				}
			}

			return array_merge( $custom_links, $links );
		}

		/**
		 * Sets the plugin args
		 *
		 * @version 1.0.0
		 * @since   1.0.0
		 *
		 * @param array $args
		 */
		public function set_args( $args = array() ) {
			$args = wp_parse_args( $args, array(
				'plugin_file_path' => null,
				'translation'      => null,
				'action_links'     => null,
			) );

			$args['translation'] = wp_parse_args( $args['translation'], array(
				'text_domain' => 'my_plugin',
				'folder'      => 'languages',
			) );

			$args['action_links'] = wp_parse_args( $args['action_links'], array(
				array(
					'url'  => '',
					'text' => '',
				),
			) );

			$this->args = $args;
		}
	}
}