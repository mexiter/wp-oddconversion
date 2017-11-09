<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define the internationalization functionality.
 * 
 * @package       OddsConverter
 * @subpackage    OddsConverter/setup
 * @author        Merxhan Emini <https://symphony-solutions.eu>
 */

if( ! class_exists( 'OddsConverter_Translation' ) ) {

	class OddsConverter_Translation {

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
		 * Load the plugin text domain for translation.
		 * 
		 * @link https://developer.wordpress.org/reference/functions/load_plugin_textdomain
		 */
		public function load_textdomain() {

			load_plugin_textdomain(
				$this->plugin['id'],
				false,
				dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
			);

		}

	}

}
