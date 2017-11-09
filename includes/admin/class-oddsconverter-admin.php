<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Defines the admin functionality.
 *
 * @package       OddsConverter
 * @subpackage    OddsConverter/admin
 * @author        Merxhan Emini <https://symphony-solutions.eu>
 */

if( ! class_exists( 'OddsConverter_Admin' ) ) {

	class OddsConverter_Admin {

		/**
		 * The plugin variables container.
		 *
		 * @var    object    $plugin
		 */
		private $plugin;

		/**
		 * Construct the class.
		 *
		 * @param    object    $plugin    The plugin variables.
		 */
		public function __construct( $plugin ) {

			$this->plugin = $plugin;

		}

		/**
		 * Enqueue the admin stylesheets.
		 *
		 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_style
		 */
		public function enqueue_styles() {

			// Enqueue and localize the admin plugin stylesheet.
			wp_enqueue_style( $this->plugin['id'], $this->plugin['url'] . 'assets/admin/css/oddsconverter-admin.css', array(), $this->plugin['version'], 'all' );

		}

		/**
		 * Enqueue the admin scripts.
		 *
		 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_script
		 */
		public function enqueue_scripts() {

			// Enqueue and localize the admin plugin script.
			wp_enqueue_script( $this->plugin['id'], $this->plugin['url'] . 'assets/admin/js/oddsconverter-admin.js', array( 'jquery' ), $this->plugin['version'], true );

		}

		/**
		 * Extend the default action links.
		 *
		 * @param     array    $actions       Associative array of action names to anchor tags.
		 * @return    array    Associative array of plugin action links,
		 */
		public function action_links( $actions ) {

			return array_merge( array(
				'<a href="' . admin_url( 'admin.php?page=' . $this->plugin['id'] ) . '">' .
					__( 'Settings', 'oddsconverter' ) .
				'</a>',
			), $actions );

		}

	}

}
