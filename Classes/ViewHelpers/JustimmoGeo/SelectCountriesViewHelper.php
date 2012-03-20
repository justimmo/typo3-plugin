<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Thomas Juhnke <tommy@van-tomas.de>
 *  
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/


/**
 * ViewHelper for retrieving a <select> list from justimmo geo API
 * 
 * @package justimmo
 * @subpackage ViewHelpers\JustimmoGeo
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class Tx_Justimmo_ViewHelpers_JustimmoGeo_SelectCountriesViewHelper extends Tx_Fluid_ViewHelpers_Form_SelectViewHelper implements Tx_Justimmo_Core_ViewHelper_JustimmoGeoViewHelperInterface {

	/**
	 *
	 * @var Tx_Justimmo_Service_JustimmoApiService
	 */
	protected $api;

	/**
	 * injects the justimmo API service into the VH
	 *
	 * @param Tx_Justimmo_Service_JustimmoApiService $justimmoApiService
	 */
	public function injectJustimmoApiService(Tx_Justimmo_Service_JustimmoApiService $justimmoApiService) {
		$this->api = $justimmoApiService;
	}

	/**
	 * (non-PHPdoc)
	 * @see Tx_Fluid_ViewHelpers_Form_SelectViewHelper::initializeArguments()
	 */
	public function initializeArguments() {
		parent::initializeArguments();

		$this
			->registerArgument('keyField', 'string', 'Specifies the key field for the options key.', FALSE, 'id');

		// override options argument
		$this
			->overrideArgument('options', 'array', 'Associative array with internal IDs as key, and the values are displayed in the select box', FALSE);
	}

	/**
	 * (non-PHPdoc)
	 * @see Tx_Fluid_ViewHelpers_Form_SelectViewHelper::getOptions()
	 */
	protected function getOptions() {
		$options = array();

		if (0 === count($this->arguments['options'])) {
			$keyField = $this->arguments['keyField'];

			$optionsInternal = $this->api->getCountries();
	
			$options = array();
			foreach ($optionsInternal as $country) {
				$keyFieldValue = (string) $country->$keyField;
				$key = (FALSE === empty($keyFieldValue)) ? $keyFieldValue : (string) $country->id;

				$options[$key] = (string) $country->name;
			}
		} else {
			$options = parent::getOptions();
		}

		return $options;
	}
}
?>
