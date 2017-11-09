<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main Class.
 *
 * Loads dependencies, handles translation, registers admin and public hooks.
 *
 * @package       OddsConverter
 * @subpackage    OddsConverter/includes
 * @author        Merxhan Emini <https://symphony-solutions.eu>
 */

if( ! class_exists( 'OddsConverter_Main' ) ) {

	class OddsConverter_Main {

		/**
		 * The plugin variables container.
		 *
		 * @var    object    $plugin
		 */
		private $plugin;

		/**
		 * The plugin loader that registers actions and filters.
		 *
		 * @var OddsConverter_Loader
		 */
		protected $loader;

		/**
		 * Construct the class.
		 *
		 * @param    object    $plugin    The plugin variables.
		 */
		public function __construct( $plugin ) {

			$this->plugin = $plugin;

			$this->load_dependencies();
			$this->define_translation();
			$this->define_admin_hooks();
			$this->define_public_hooks();

		}

		/**
		 * Load the dependencies.
		 *
		 * Require all the classes and create an instance of the loader
		 * which will be used to register the hooks with WordPress.
		 */
		private function load_dependencies() {

			/**
			 * Require the plugin loader and internationalization setup classes.
			 *
			 * @see    OddsConverter_Loader         Orchestrates the hooks of the plugin.
			 * @see    OddsConverter_Translation    Defines internationalization functionality.
			 */
			require_once $this->plugin['path'] . 'includes/setup/class-oddsconverter-loader.php';
			require_once $this->plugin['path'] . 'includes/setup/class-oddsconverter-translation.php';

			/**
			 * Require the admin classes.
			 *
			 * @see    OddsConverter_Admin         Defines all hooks for the admin area.
			 * @see    OddsConverter_Settings      Defines the settings page and fields.
			 * @see    OddsConverter_Post_Types    Defines the custom post types.
			 * @see    OddsConverter_Meta          Defines the custom meta boxes.
			 */
			require_once $this->plugin['path'] . 'includes/admin/class-oddsconverter-admin.php';
			require_once $this->plugin['path'] . 'includes/admin/class-oddsconverter-settings.php';
			require_once $this->plugin['path'] . 'includes/admin/class-oddsconverter-types.php';
			require_once $this->plugin['path'] . 'includes/admin/class-oddsconverter-meta.php';

			/**
			 * Require the public classes.
			 *
			 * @see    OddsConverter_Public       Defines all hooks for the public side of the site.
			 * @see    OddsConverter_Ajax         Defines the public ajax functionality.
			 * @see    OddsConverter_Templates    Defines the public templates.
			 */
			require_once $this->plugin['path'] . 'includes/public/class-oddsconverter-public.php';
			require_once $this->plugin['path'] . 'includes/public/class-oddsconverter-ajax.php';
			require_once $this->plugin['path'] . 'includes/public/class-oddsconverter-templates.php';



			/**
			 * Require the public classes.
			 *
			 * @see    OddsConverter_Validator        Defines the validate functionality
			 * @see    Odds_Converter_Convert         Defines the public convert functionality.
			 *
			 */
			require_once $this->plugin['path'] . 'includes/public/class-oddsconverter-validator.php';
			require_once $this->plugin['path'] . 'includes/public/class-oddsconverter-convert.php';




			/**
			 * Initialize the action & filter loader.
			 *
			 * @see    OddsConverter_Loader    Defines the loader used to register actions and hooks.
			 */
			$this->loader = new OddsConverter_Loader();

		}

		/**
		 * The plugin translation.
		 *
		 * @see    OddsConverter_Translation::load_textdomain()    Load the plugin text domain for translation.
		 */
		private function define_translation() {
			$translation = new OddsConverter_Translation( $this->plugin );
			$this->loader->add_action( 'plugins_loaded', $translation, 'load_textdomain' );
		}

		/**
		 * The admin actions and filters.
		 */
		private function define_admin_hooks() {

			/**
			 * Admin
			 *
			 * @see    OddsConverter_Admin::enqueue_styles()     Enqueue the admin stylesheets.
			 * @see    OddsConverter_Admin::enqueue_scripts()    Enqueue the admin scripts.
			 * @see    OddsConverter_Admin::action_links()       Extend the default action links.
			 */
			$admin = new OddsConverter_Admin( $this->plugin );
			$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_styles' );
			$this->loader->add_action( 'admin_enqueue_scripts', $admin, 'enqueue_scripts' );
			$this->loader->add_filter( 'plugin_action_links_' . $this->plugin['basename'], $admin, 'action_links' );

			/**
			 * Settings
			 *
			 * @see    OddsConverter_Settings::add_settings_page()    Register the settings menu page.
			 * @see    OddsConverter_Settings::add_settings()         Register the settings.
			 */
			$settings = new OddsConverter_Settings( $this->plugin );
			$this->loader->add_action( 'admin_menu', $settings, 'add_settings_page' );
			$this->loader->add_action( 'admin_init', $settings, 'add_settings' );

			/**
			 * Custom Post Types
			 *
			 * @see    OddsConverter_Post_Types::register_type_item()                 Register the "item" post type.
			 * @see    OddsConverter_Post_Types::register_taxonomy_item_category()    Register the "item_category" taxonomy.
			 */
			$post_types = new OddsConverter_Post_Types( $this->plugin );
			$this->loader->add_action( 'init', $post_types, 'register_type_item' );
			$this->loader->add_action( 'init', $post_types, 'register_taxonomy_item_category' );

			/**
			 * Meta Boxes
			 */
			$meta_boxes = new OddsConverter_Meta();

		}

		/**
		 * The public actions and filters.
		 */
		private function define_public_hooks() {

			/**
			 * Public
			 *
			 * @see    OddsConverter_Public::enqueue_styles()     Enqueue the public stylesheets.
			 * @see    OddsConverter_Public::enqueue_scripts()    Enqueue the public scripts.
			 */
			$public = new OddsConverter_Public( $this->plugin );
			$this->loader->add_action( 'wp_enqueue_scripts', $public, 'enqueue_styles' );
			$this->loader->add_action( 'wp_enqueue_scripts', $public, 'enqueue_scripts' );

			/**
			 * Templates
			 *
			 * @see    OddsConverter_Templates::shortcode_template_item()     Setup the single template for the 'item' custom post type.
			 * @see    OddsConverter_Templates::archive_template_item()    Setup the archive template for the 'item' custom post type.
			 */
			$templates = new OddsConverter_Templates( $this->plugin );
			$this->loader->add_filter( 'single_template', $templates, 'shortcode_template_item' );
			$this->loader->add_filter( 'archive_template', $templates, 'archive_template_item' );



			//Actions
			$this->loader->add_action('init', $templates, 'odds_make_shortcode');

			/**
			 * Validator
			 *
			 * @see    OddsConverter_Validator::doValidate($odds, $sOddsType)     Validate the input fields.
			 *
			 */
			$validator = new OddsConverter_Validator( $this->plugin );
			$this->loader->add_filter( 'validate', $validator, 'doValidate' );


			/**
			 * Convert
			 *
			 * @see    OddsConverter_Convert::doConverting($iOddsFromUser, $sUserOddsType)     Validate the input fields.
			 *
			 */
			$convert = new OddsConverter_Convert( $this->plugin, $this->iOddsFromUser, $this->sUserOddsType );
			$this->loader->add_filter( 'convert', $convert, 'doConverting' );

			/**
			 * AJAX
			 *
			 * @see    OddsConverter_Ajax::wp_ajax_nopriv_callback()    Setup an example AJAX callback.
			 * @see    OddsConverter_Ajax::wp_ajax_callback()
			 */
			$ajax = new OddsConverter_Ajax( $this->plugin );
			$this->loader->add_action( 'wp_ajax_nopriv_callback', $ajax, 'callback' );
			$this->loader->add_action( 'wp_ajax_callback', $ajax, 'callback' );


			//$this->loader->add_action( 'wp_footer', $ajax, 'callback' );

			// $iOddsFromUser = 3; $sUserOddsType ='uk';
			// $args = array( $iOddsFromUser, $sUserOddsType );
			// $result = apply_filters_ref_array( 'validate', $args );
			// $result = apply_filters_ref_array( 'convert', $args );
		  // $result = wp_json_encode($result);
			// var_dump($result);
		}

		/**
		 * The plugin hook loader.
		 *
		 * @see    OddsConverter_Loader::run()    Register the filters and actions with WordPress.
		 */
		public function run() {
			$this->loader->run();
		}

	}

}
