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
 *
 *
 * @package justimmo
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
*
*/
class Tx_Justimmo_Domain_Repository_RealtyRepository implements t3lib_Singleton { //extends Tx_Extbase_Persistence_Repository {

	/**
	 *
	 * @var Tx_Justimmo_Service_JustimmoApiService
	 */
	protected $api;

	protected $defaults = array();

	protected $max_per_page = 5;

	protected $page = 1;

	protected $total_count = 0;

	protected $filter = '';

	protected $orderby = '';

	protected $repositorySettings = array();

	public function injectJustimmoApiService(Tx_Justimmo_Service_JustimmoApiService $justimmoApiService) {
		$this->api = $justimmoApiService;
	}

	public function injectConfigurationManager(Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager) {
		$configuration = $configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManager::CONFIGURATION_TYPE_SETTINGS);
		$this->repositorySettings = (array) $configuration['settings']['realtyRepository'];
	}

	public function initializeObject() {
		$this->defaults = $this->repositorySettings['defaults'];

		$this->loadFromSession();
	}

	public function loadFromSession() {
		if (isset($_SESSION['ji_objekt_list'])) {
			$objekt_list_params = $_SESSION['ji_objekt_list'];
		} else {
			$objekt_list_params = $this->defaults;
		}

		$this->filter = $objekt_list_params['filter'];
		$this->orderby = $objekt_list_params['orderby'];

		if (isset($objekt_list_params['page'])) {
			$this->page = $objekt_list_params['page'];
		}

		if (isset($objekt_list_params['total_count'])) {
			$this->total_count = (int) $objekt_list_params['total_count'];
		}
	}

	public function saveToSession() {
		$_SESSION['ji_objekt_list'] = array();
		$_SESSION['ji_objekt_list']['filter'] = $this->filter;
		$_SESSION['ji_objekt_list']['page'] = $this->page;
		$_SESSION['ji_objekt_list']['orderby'] = $this->orderby;
		$_SESSION['ji_objekt_list']['total_count'] = $this->total_count;
	}

	public function fetchList() {
		$obj_list = $this->api->getList(
			array(),
			$this->filter,
			$this->orderby,
			$this->max_per_page * ($this->page - 1),
			$this->max_per_page
		);
		$this->total_count = (int) $obj_list->{'query-result'}->count;

		return $obj_list;
	}

	public function fetchItemById($id) {
		$xml = $this->ji_client->getDetail($id);

		return $xml->immobilie[0];
	}

	public function fetchItemByPosition($pos) {
		$obj_list = $this->api->getList(
			array(),
			$this->filter,
			$this->orderby,
			$pos - 1,
			1
		);

		return $this->fetchItemById($obj_list->immobilie[0]->id);
	}

	public function setMaxPerPage($max) {
		$this->max_per_page = $max;
	}

	public function getMaxPerPage() {
		return $this->max_per_page;
	}

	public function setPage($page) {
		$this->page = $page;
	}

	public function getPage() {
		return $this->page;
	}

	public function setFilter($filter) {
		$this->filter = $filter;
	}

	public function resetFilter() {
		$this->filter = $this->defaults['filter'];
		$this->orderby = $this->defaults['orderby'];
		$this->page = 1;
		$this->total_count = 0;
	}

	public function setOrderBy($orderby) {
		$this->orderby = $orderby;
	}

	public function getTotalCount() {
		return $this->total_count;
	}
}
?>