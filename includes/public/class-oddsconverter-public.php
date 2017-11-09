<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define the public functionality of the plugin.
 *
 * @package       OddsConverter
 * @subpackage    OddsConverter/public
 * @author        Merxhan Emini <https://symphony-solutions.eu>
 */

if( ! class_exists( 'OddsConverter_Public' ) ) {

	class OddsConverter_Public {

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
		 * Enqueue the public stylesheets.
		 *
		 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_style
		 */
		public function enqueue_styles() {

			/**
			 * Register and enqueue boostrap from CDN
			 */
			wp_register_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css' );
			wp_enqueue_style('bootstrap');


			/**
			 * Enqueue and register font-awesome from CDN
			 */
			wp_register_style( 'Font_Awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' );
			wp_enqueue_style('Font_Awesome');


			// Enqueue and localize the public plugin script.
			wp_enqueue_style( $this->plugin['id'], $this->plugin['url'] . 'assets/public/css/oddsconverter-public.css', array(), $this->plugin['version'], 'all' );

		}

		/**
		 * Enqueue the public scripts.
		 *
		 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_script
		 * @link https://developer.wordpress.org/reference/functions/wp_localize_script
		 */
		public function enqueue_scripts() {

				/**
			 * Register and enqueue bootstrap from the CDN on footer
			 */
			wp_register_script( 'bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', null, $this->plugin['version'], true );
			wp_enqueue_script('bootstrap-js');

			// Enqueue form-validator script.
			wp_enqueue_script('form-validator', $this->plugin['url'] . 'assets/public/js/oddsconverter-form-validator.js', array( 'jquery' ), $this->plugin['version'], true );

			// Enqueue and localize the public plugin script.
			wp_enqueue_script( $this->plugin['id'], $this->plugin['url'] . 'assets/public/js/oddsconverter-public.js', array( 'jquery' ), $this->plugin['version'], true );
			wp_localize_script( $this->plugin['id'], $this->plugin['id'], array(
				'ajax_url' => admin_url( 'admin-ajax.php' ),
				'nonce'    => wp_create_nonce( $this->plugin['id'] )
			) );
		}

	}

}
