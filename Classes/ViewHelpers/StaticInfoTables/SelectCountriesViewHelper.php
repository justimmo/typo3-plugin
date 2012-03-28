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
 * ViewHelper for rendering a <select> list from static_info_tables API
 * 
 * @see tx_staticinfotables_pi1::buildStaticInfoSelector()
 *
 * @package justimmo
 * @subpackage ViewHelpers\StaticInfoTables
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @author Thomas Juhnke <tommy@van-tomas.de>
 */
class Tx_Justimmo_ViewHelpers_StaticInfoTables_SelectCountriesViewHelper extends Tx_Fluid_ViewHelpers_Form_SelectViewHelper implements Tx_Justimmo_Core_ViewHelper_StaticInfoTablesViewHelperInterface {
	
	/**
	 * reference to static_info_tables API
	 *
	 * @var tx_staticinfotables_pi1
	 */
	protected $api;

	/**
	 * holds an array of countries which should be displayed on the top of the country select list
	 *
	 * @var array
	 */
	protected $firstCountries = array();

	/**
	 * injects the static_info_tables API service
	 *
	 * @param Tx_Justimmo_Service_StaticInfoTablesApiInitService $staticInfoTablesApiInitService
	 */
	public function injectStaticInfoTablesApiInitService(Tx_Justimmo_Service_StaticInfoTablesApiInitService $staticInfoTablesApiInitService) {
		$this->api = $staticInfoTablesApiInitService->getApi();
	}

	/**
	 * initializing the arguments for this view helper
	 * 
	 * This method basically re-maps all the arguments of tx_staticinfotables_pi1::buildStaticInfoSelector()
	 * 
	 * @return void
	 */
	public function initializeArguments() {
		parent::initializeArguments();

		$this
			->registerArgument('apiAddWhere', 'string', 'A where clause for the records', FALSE, '')
			->registerArgument('apiLang', 'string', 'language to be used', FALSE, '')
			->registerArgument('apiLocal', 'boolean', 'If set, we are looking for the "local" title field', FALSE, FALSE)
			->registerArgument('overrideInit', 'boolean', 'If set, the ViewHelper initCountries method is used', FALSE, FALSE)
			->registerArgument('initIdField', 'string', 'Specifies the initCountries id field param', FALSE, 'cn_iso_2')
			->registerArgument('firstCountries', 'array', 'Specifies the firstCountries array', FALSE, array());

		// overrides argument "options" from Tx_Fluid_ViewHelpers_Form_SelectViewHelper
		$this
			->overrideArgument('options', 'array', 'Associative array with internal IDs as key, and the values are displayed in the select box', FALSE);
	}

	/**
	 * returns the options for the select list
	 *
	 * This method overrides the SelectViewHelper by fetching the options
	 * via static_info_tables_pi1::initCountries() call
	 *
	 * @return array an associative array of options, key will be the value of the option tag
	 * @todo refactor multiple exit points
	 * @todo refactor for multiple TYPO3/extbase/fluid versions (4.5, 4.6+)
	 */
	protected function getOptions() {
		if (TRUE === $this->arguments['overrideInit']) {
			$options = $this->initCountries(
				'ALL',
				$this->arguments['apiLang'],
				$this->arguments['apiLocal'],
				$this->arguments['apiAddWhere'],
				$this->arguments['initIdField']
			);

			return $options;
		}

		// setting $this->arguments works in TYPO3 > 4.5 (array instead of Tx_Fluid_Core_ViewHelper_Arguments) 
		try {
			if (FALSE === $this->arguments['options']
					|| 0 === count($this->arguments['options'])) {
				$this->arguments['options'] = $this->api->initCountries(
					'ALL', 
					$this->arguments['apiLang'], 
					$this->arguments['apiLocal'], 
					$this->arguments['apiAddWhere']
				);
			}

			return parent::getOptions();
		// in TYPO3 < 4.6 the setting of $this->arguments[] leds to an exception
		} catch (Exception $e) {
			$options = $this->arguments['options'];
			if (FALSE === $options || 0 === count($options)) {
				$options = $this->api->initCountries(
					'ALL',
					$this->arguments['apiLang'],
					$this->arguments['apiLocal'],
					$this->arguments['apiAddWhere']
				);
			}

			return $options;
		}
	}

	/**
	 * modified API method which initializes the country list array
	 *
	 * As an addon to the default API method, you can define a key field, which
	 * defaults to cn_iso_2 (but is unchangeable in the API)
	 *
	 * @param string $param restricts the countries to a specific region; valid values: UN, EU, ALL
	 * @param string $lang allows changing the query language
	 * @param boolean $local flags if the local version of the country name
	 * @param string $addWhere allows adding of further WHERE clause criteria
	 * @param string $id_field allows changing the ID field (defaults to cn_iso_2)
	 * @return array country array, $id_field as key value is country name
	 */
	protected function initCountries($param = 'UN', $lang = '', $local = FALSE, $addWhere = '', $id_field = 'cn_iso_2') {
		$table = $this->api->tables['COUNTRIES'];

		if (!$lang) {
			$lang = $this->api->getCurrentLanguage();
		}

		$nameArray = array();

		$titleFields = tx_staticinfotables_div::getTCAlabelField($table, TRUE, $lang, $local);

		$prefixedTitleFields = array();
		$prefixedTitleFields = $table . $id_field;

		foreach ($titleFields as $titleField) {
			$prefixedTitleFields[] = $table . '.' . $titleField;
		}

		array_unique($prefixedTitleFields);

		$labelFields = implode(',', $prefixedTitleFields);

		if ($param == 'UN') {
			$where = 'cn_uno_member=1';
		} elseif ($param == 'EU') {
			$where = 'cn_eu_member=1';
		} elseif ($param == 'ALL')	{
			$where = '1=1';
		} else {
			$where = '1=1';
		}

		$where .= ($addWhere ? ' AND '. $addWhere : '');

		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
			$labelFields,
			$table,
			$where . $GLOBALS['TSFE']->sys_page->enableFields($table)
		);

		while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) 	{
			foreach ($titleFields as $titleField) {
				if ($row[$titleField]) {
					$nameArray[$row[$id_field]] = $GLOBALS['TSFE']->csConv(
						$row[$titleField], 
						$TYPO3_CONF_VARS['EXTCONF']['static_info_tables']['charset']);
					break;
				}
			}
		}
		$GLOBALS['TYPO3_DB']->sql_free_result($res);

		uasort($nameArray, 'strcoll');
		$new = array_filter($nameArray, array($this, 'filterCountries'));

		if ($id_field == 'cn_iso_2') {
			$nameArray = array_merge($this->firstCountries, $new);
		} else {
			$nameArray = $this->arguments['firstCountries'] + $new;
		}

		return $nameArray;
	}

	/**
	 * filters a country list
	 *
	 * @param array $var the queried country array
	 */
	protected function filterCountries($var) {
		if (in_array($var, $this->arguments['firstCountries'])) {
			return false;
		}

		return true;
	}
}
?>