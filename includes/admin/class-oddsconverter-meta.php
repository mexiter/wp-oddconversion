<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Defines the custom meta boxes.
 *
 * @package       OddsConverter
 * @subpackage    OddsConverter/admin
 * @author        Merxhan Emini <https://symphony-solutions.eu>
 */

if( ! class_exists( 'OddsConverter_Meta' ) ) {

	class OddsConverter_Meta {

		/**
		 * Construct the class.
		 */
		public function __construct() {

			// Load the dependencies.
			$this->load_dependencies();

			// Create an example meta box for the 'item' post type.
			new Metabun( 'item', array(
				array(
					'id'     => 'section',
					'title'  => 'Meta Boxes',
					'fields' => array(
						array(
							'id'          => 'text',
							'title'       => __( 'Text', 'oddsconverter' ),
							'type'        => 'text',
							'description' => 'This is an example text field.'
						),
					),
					'context'  => 'normal',
					'priority' => 'default'
				)
			) );

		}

		/**
		 * Load the dependencies.
		 */
		private function load_dependencies() {

			/**
			 * Require the Metabun class for custom meta boxes.
			 *
			 * @link https://github.com/AlexandruDoda/Metabun
			 */
			require_once dirname( __FILE__ ) . '/libraries/metabun/class-metabun.php';

		}

	}

}
