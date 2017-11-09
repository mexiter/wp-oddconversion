<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define the public AJAX functionality.
 *
 * @package       OddsConverter
 * @subpackage    OddsConverter/public
 * @author        Merxhan Emini <https://symphony-solutions.eu>
 */

if( ! class_exists( 'OddsConverter_Ajax' ) ) {

	class OddsConverter_Ajax {

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
		 * Define an example AJAX request.
		 */
		public function callback() {

			// Check the nonce for permission.
			if( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], $this->plugin['id'] ) ) {
				die( 'Permission Denied' );
			}

			//validate inputs
			if (!empty($_POST["qbo_user_odds"]) && !empty($_POST["odds_type"])) {
					$iOddsFromUser = trim($_POST["qbo_user_odds"]);
					$sUserOddsType = trim($_POST["odds_type"]);
					$result = array($iOddsFromUser, $sUserOddsType);

			} else {
					$result = array('no', 'Something went wrong');
					wp_die(wp_json_encode($result));
					die;
			}

			if(has_filter('validate')) {
				$isValid = apply_filters('validate', $iOddsFromUser, $sUserOddsType);
				if(!$isValid) {
					$result = array('no', 'check your format');
					 wp_send_json($result);
					 wp_die( json_encode( $result ) );
				}
			}


			$result = apply_filters( 'convert', $result );
		  $result = wp_json_encode($result);



			// $oValidator = new Odss_Converter_Validator();
			// $isValid = $oValidator->doValidate($iOddsFromUser, $sUserOddsType);
			// if (!$isValid) {
			//     $result = array('no', 'Check the format!');
			//     wp_send_json($result);
		  //   	wp_die( json_encode( $result ) );
			// }
			// $oOddsConverter = new Odds_Converter_Converter($iOddsFromUser, $sUserOddsType);
			// $result = $oOddsConverter->doConverting();
			// $result = json_encode($result);

			//$result = wp_send_json_success($result);
			//$oLog = new Log();
			//$oLog->saveLog($result);
			//$oSaveData = new SaveData();
			//$oSaveData->saveConvertedOdds($result);
			//echo $result;

			// Get the request data.
			$request = array(
					'result' 					=> $result ? $result :'default',
				  'qbo_user_odds' => $iOddsFromUser ? $iOddsFromUser : 'default',
				  'odds_type'			=> $sUserOddsType ? $sUserOddsType : 'default'

			);

			// Define an empty response array.
			$response = array(
				'qbo_user_odds' => $request['qbo_user_odds'],
				'odds_type'			=> $request['odds_type'],
				'result'				=> $request['result']

			);
			wp_send_json($response);
			// Terminate the callback and return a proper response.
			wp_die( wp_json_encode( $response ) );






		}

	}

}
