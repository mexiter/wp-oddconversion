<?php

/**
 * Plugin Name:       OddsConverter
 * Plugin URI:        https://oddsconverter.com/
 * Description:       Plugin for betting odds conversion
 * Version:           1.0.0
 * Author:            Merxhan Emini
 * Author URI:        https://symphony-solutions.eu/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       oddsconverter
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'OddsConverter' ) ) {

	class OddsConverter {

		/**
		 * The plugin variables container.
		 *
		 * @var    object    $plugin
		 */
		private $plugin;

		/**
		 * The class instance.
		 *
		 * @var Plugin
		 */
		protected static $instance = null;

		/**
		 * Construct the class.
		 */
		public function __construct() {

			// Define the plugin variables container.
			$this->plugin = array(
				'name'     => __( 'OddsConverter', 'oddsconverter' ),
				'id'       => 'oddsconverter',
				'version'  => '1.0.0',
				'basename' => plugin_basename( __FILE__ ),
				'path'     => plugin_dir_path( __FILE__ ),
				'url'      => plugin_dir_url( __FILE__ )
			);

			// Set the activation hook for the plugin.
			register_activation_hook( __FILE__, array( $this, 'activate' ) );

			// Set the deactivation hook for the plugin.
			register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

			// Run the plugin by calling the main class.
			$this->run();

		}

		/**
		 * Set the activation hook for the plugin.
		 *
		 * @see     OddsConverter_Activator
		 * @link    https://developer.wordpress.org/reference/functions/register_activation_hook/
		 */

		public function activate() {
			require $this->plugin['path'] . 'includes/setup/class-oddsconverter-activator.php';
			OddsConverter_Activator::activate();
		}

		/**
		 * Set the deactivation hook for the plugin.
		 *
		 * @see     OddsConverter_Deactivator
		 * @link    https://developer.wordpress.org/reference/functions/register_deactivation_hook/
		 */

		public function deactivate() {
			require $this->plugin['path'] . 'includes/setup/class-oddsconverter-deactivator.php';
			OddsConverter_Deactivator::deactivate();
		}

		/**
		 * Run the plugin by calling the main class.
		 *
		 * Since everything within the plugin is registered via hooks,
		 * then kicking off the plugin from this point in the file does
		 * not affect the page life cycle.
		 *
		 * @see OddsConverter_Main
		 */

		private function run() {
			require $this->plugin['path'] . 'includes/class-oddsconverter.php';
			$plugin = new OddsConverter_Main( $this->plugin );
			$plugin->run();
		}

		/**
		 * Get the class instance.
		 *
		 * @return    class    $instance    The 'OddsConverter' class instance, if it exists.
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

	}

}

return OddsConverter::instance();
