<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 B&G Consulting & Commerce GmbH <office@bgcc.at>
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
 * ViewHelper for retrieving a <select> list of subdivisions from justimmo geo API
 * 
 * @package justimmo
 * @subpackage ViewHelpers\JustimmoGeo
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @author Thomas Juhnke <tommy@van-tomas.de>
 */
class Tx_Justimmo_ViewHelpers_JustimmoGeo_SelectSubDivisionsViewHelper extends Tx_Fluid_ViewHelpers_Form_SelectViewHelper implements Tx_Justimmo_Core_ViewHelper_JustimmoGeoViewHelperInterface {

	/**
	 * a justimmo API service reference
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
	 * Initialize arguments.
	 *
	 * This method overrides the default by adding some new arguments to this
	 * viewhelper: keyField (defines option elements key field value), countryCode
	 * (specifies which country's sub divisions should be selected), countryId
	 * (same as countryCode, but numeric) and includeBlank (flags if an empty
	 * option element should be rendered on top of the option list)
	 *
	 * @return void
	 * @api
	 */
	public function initializeArguments() {
		parent::initializeArguments();

		$this
			->registerArgument('keyField', 'string', 'Specifies the key field for the options key.', FALSE, 'id')
			->registerArgument('countryCode', 'string', 'Specifies for which country the subdivisions should be fetched', FALSE)
			->registerArgument('countryId', 'integer', 'Specifies for which country the subdivisions should be fetched', FALSE)
			->registerArgument('includeBlank', 'boolean', 'Flags if a blank list item should be added to the top of the options list', FALSE, TRUE);
		
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

		if (TRUE === $this->arguments['includeBlank']) {
			$options[''] = '';
		}

		if (0 === count($this->arguments['options'])) {
			$countryIdent = NULL;

			if (NULL !== $this->arguments['countryCode']) {
				$countryIdent = $this->arguments['countryCode'];
			} elseif (NULL !== $this->arguments['countryId']) {
				$countryIdent = $this->arguments['countryId'];
			}

			$optionsInternal = $this->api->getSubDivisions($countryIdent);

			$keyField = $this->arguments['keyField'];

			foreach ($optionsInternal as $subdivision) {
				$keyFieldValue = (string) $subdivision->$keyField;
				$key = (FALSE === empty($keyFieldValue)) ? $keyFieldValue : (string) $subdivision->id;
				
				$options[$key] = (string) $subdivision->name;
			}
		} else {
			$options = parent::getOptions();
		}

		return $options;
	}
}
?>