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

if( ! class_exists( 'OddsConverter_Convert' ) ) {

	class OddsConverter_Convert {
	/**
 	* The plugin variables container.
 	*
 	* @var    object    $plugin
 	*/
  private $plugin;

	private $iOddsFromUser;
	private $sUserOddsType;


	public function __contstruct($iOddsFromUser, $sUserOddsType) {

		$this->plugin = $plugin;

		$this->iOddsFromUser = $iOddsFromUser;
		$this->sUserOddsType = $sUserOddsType;
	}

	public function doConverting() {
        switch ($this->sUserOddsType) {
            case "uk":
                $iDecimal = $this->convertDecimalFromFraction($this->iOddsFromUser);
                break;
            case "eu":
                $iDecimal = floatval($this->iOddsFromUser);
                break;
            case "usa":
                $iDecimal = $this->convertDecimalFromUs($this->iOddsFromUser);
                break;
        }
        $aResult = array();
        if (is_numeric($iDecimal) && $iDecimal > 0) {
            $aResult[0] = "ok";
            $aResult[1] = $this->convertFractionalFromDecimal($iDecimal);
            $aResult[2] = round(($iDecimal * 100 ) / 100, 2);
            $aResult[3] = $this->convertUsFromDecimal($iDecimal);
        }
        return $aResult;
    }


	public function convertDecimalFromFraction($sFraction) {
		$aNumbers = explode ("/", $sFraction);
		if(count($aNumbers) == 2 && is_numeric($aNumbers[0]) && is_numeric($aNumbers[1])) {
			return ($aNumbers[0] / $aNumbers[1]) + 1;
		}
		return false;
	}

	public function convertDecimalFromUs($iDecimal) {
		if($iDecimal > 0) {
			return ($iDecimal / 100) +1;
		} else {
			return (100 / $iDecimal * -1) +1;
		}
	}

	public function convertUsFromDecimal($iDecimal) {
        $iDecimal -= 1;
        if ($iDecimal < 1) {
            return '-' . abs(round((100 / $iDecimal), 2));
        } else {
            return '+' . round(($iDecimal * 100), 2);
        }
    }

	public function convertFractionalFromDecimal($iDecimal) {
		$iDecimal = round(floatval($iDecimal), 2);
		$iNumber = round(($iDecimal - 1) * 10000);
		$iDom = round(10000);

		$aReduced = $this->reduce($iNumber, $iDom);
		$iNumber = $aReduced[0];
		$iDom = $aReduced[1];

		return $iNumber . '/' . $iDom;
	}

	public function reduce($iNumber, $iDom) {
		$aReduced = array();
		$iGcd = $this->GcdCalculator($iNumber, $iDom);
		$aReduced[0] = $iNumber / $iGcd;
		$aReduced[1] = $iDom / $iGcd;
		return $aReduced;
	}

	public function GcdCalculator($iNumber1, $iNumber2) {
		return ($iNumber1 % $iNumber2) ? $this->GcdCalculator($iNumber2, $iNumber1 % $iNumber2) : $iNumber2;
	}
}

}
