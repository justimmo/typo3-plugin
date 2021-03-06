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
 * the realty repository
 *
 * This repository is special because it doesn't implement extbase's default
 * persistance layer repository. This repo is querying the justimmo API service
 * layer to fetch the realty objects.
 *
 * @package justimmo
 * @subpackage Domain\Repository
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Thomas Juhnke <tommy@van-tomas.de>
 */
class Tx_Justimmo_Domain_Repository_RealtyRepository implements t3lib_Singleton {

	/**
	 * a justimmo API service reference
	 *
	 * @var Tx_Justimmo_Service_JustimmoApiService
	 */
	protected $api;

	/**
	 * holds default list parameters
	 *
	 * @var array
	 */
	protected $defaults = array();

	/**
	 * maximum realty items per page
	 *
	 * @var integer
	 */
	protected $max_per_page = 5;

	/**
	 * current page
	 *
	 * @var integer
	 */
	protected $page = 1;

	/**
	 * total amount of realty items
	 *
	 * @var integer
	 */
	protected $total_count = 0;

	/**
	 * list filter array
	 *
	 * @var array
	 */
	protected $filter = array();

	/**
	 * list filter ordering instruction
	 *
	 * @param string
	 */
	protected $orderby = '';

	/**
	 * list filter order direction
	 *
	 * @param string
	 */
	protected $ordertype = 'asc';

	/**
	 * repository settings
	 *
	 * @var array
	 */
	protected $repositorySettings = array();

	/**
	 * a user service reference
	 *
	 * @var Tx_Justimmo_Service_UserService
	 */
	protected $userService;

	/**
	 * a reference to the object manager
	 *
	 * @var Tx_Extbase_Object_ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * injects the justimmo API service
	 *
	 * @param Tx_Justimmo_Service_JustimmoApiService $justimmoApiService
	 * @return void
	 */
	public function injectJustimmoApiService(Tx_Justimmo_Service_JustimmoApiService $justimmoApiService) {
		$this->api = $justimmoApiService;
	}

	/**
	 * injects the configuration manager
	 *
	 * @param Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager
	 * @return void
	 */
	public function injectConfigurationManager(Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager) {
		$configuration = $configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManager::CONFIGURATION_TYPE_SETTINGS);
		$this->repositorySettings = (array) $configuration['realtyRepository'];
	}

	/**
	 * injects the user session service
	 *
	 * @param Tx_Justimmo_Service_UserService $userService
	 * @return void
	 */
	public function injectUserService(Tx_Justimmo_Service_UserService $userService) {
		$this->userService = $userService;
	}

	/**
	 * injects the object manager into the repository
	 *
	 * @param Tx_Extbase_Object_ObjectManagerInterface $objectManager
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManagerInterface $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * initializes the repository
	 *
	 * Initialization consists of setting defaults and reconstitution of list
	 * parameters
	 *
	 * @return void
	 */
	public function initializeObject() {
		$this->defaults = $this->repositorySettings['defaults'];

		$this->max_per_page = $this->defaults['max_per_page'];

		$this->reconstituteListParameters();

		if ($this->repositorySettings['resetFilterOnInit']) {
			$this->resetFilter();
		}
	}

	/**
	 * reconstitutes the list parameters from user session
	 *
	 * @return void
	 */
	public function reconstituteListParameters() {
		if ($this->userService->offsetExists('list_params')) {
			$list_params = $this->userService->offsetGet('list_params');
		} else {
			$list_params = $this->defaults;
		}

		$this->filter = $list_params['filter'];
		$this->orderby = $list_params['orderby'];
		$this->ordertype = $list_params['ordertype'];

		if (isset($list_params['page'])) {
			$this->page = $list_params['page'];
		}

		if (isset($list_params['total_count'])) {
			$this->total_count = (int) $list_params['total_count'];
		}
	}

	/**
	 * persists the list parameters into user session
	 *
	 * @return void
	 */
	public function persistListParameters() {
		$data = array(
			'filter' => $this->filter,
			'page' => $this->page,
			'orderby' => $this->orderby,
			'ordertype' => $this->ordertype,
			'total_count' => $this->total_count
		);

		$this->userService->offsetSet('list_params', $data);
	}

	/**
	 * returns all realty objects, filter settings apply
	 *
	 * List constraints are applied by passing in self::$filter, $self::orderby,
	 * $self::max_per_page, $self::page. Furthermore, the total amount of realty
	 * items of the currently selected filter constraints is set
	 *
	 * @return array a collection of Realty objects
	 */
	public function findAll() {
		$xml = $this->api->getList(
			array(),
			$this->filter,
			$this->orderby,
			$this->ordertype,
			$this->max_per_page * ($this->page - 1),
			$this->max_per_page
		);

		$this->total_count = (int) $xml->{'query-result'}->count;

		$result = array();
		$i = 1;
		foreach ($xml->immobilie as $realty) {
			$realtyObj = $this->objectManager->create('Tx_Justimmo_Domain_Model_Realty', $realty);
			$realtyObj->setPosition(($this->getPage() - 1) * $this->getMaxPerPage() + $i);
			$result[] = $realtyObj;
			$i++; 
		}

		return $result;
	}

	/**
	 * finds and returns a realty object by ID
	 *
	 * @param integer $id realty object id
	 * @return Tx_Justimmo_Domain_Model_Realty
	 */
	public function findById($id) {
		$xml = $this->api->getDetail($id);

		return $this->objectManager->create('Tx_Justimmo_Domain_Model_Realty', $xml->immobilie[0]);
	}

	/**
	 * finds and returns a realty object by ID
	 *
	 * This is a convenience method for self::findById().
	 *
	 * @param integer $uid realty object id
	 * @return Tx_Justimmo_Domain_ModelRealty
	 */
	public function findByUid($uid) {
		return $this->findById($uid);
	}

	/**
	 * finds and returns a realty object by its position in the result set list
	 *
	 * @param integer $position
	 * @return Tx_Justimmo_Domain_Model_Realty
	 */
	public function findByPosition($position) {
		$xml = $this->api->getList(
			array(),
			$this->filter,
			$this->orderby,
			$this->ordertype,
			$position - 1,
			1
		);

		return $this->findById($xml->immobilie[0]->id);
	}

	/**
	 * sets max_per_page setting
	 *
	 * @param integer $max
	 */
	public function setMaxPerPage($max) {
		$this->max_per_page = $max;
	}

	/**
	 * returns max_per_page setting
	 *
	 * @return integer
	 */
	public function getMaxPerPage() {
		return $this->max_per_page;
	}

	/**
	 * sets page setting
	 *
	 * @param integer $page
	 */
	public function setPage($page) {
		$this->page = $page;
	}

	/**
	 * returns page setting
	 *
	 * @return integer
	 */
	public function getPage() {
		return $this->page;
	}

	/**
	 * sets the API list filter array
	 *
	 * @param array $filter
	 */
	public function setFilter($filter) {
		$this->filter = $filter;
	}

	/**
	 * returns the API list filter
	 *
	 * @return array
	 */
	public function getFilter() {
		return $this->filter;
	}

	/**
	 * resets the filter settings
	 *
	 * Filter & orderby setting is set to self::defaults setting. Page is set to
	 * 1 and total_count to 0.
	 *
	 * @return void
	 */
	public function resetFilter() {
		$this->filter = $this->defaults['filter'];
		$this->orderby = $this->defaults['orderby'];
		$this->ordertype = $this->defaults['ordertype'];
		$this->page = 1;
		$this->total_count = 0;

		$this->persistListParameters();
	}

	/**
	 * sets orderby setting
	 *
	 * @param string $orderby
	 * @return void
	 */
	public function setOrderBy($orderby) {
		$this->orderby = $orderby;
	}

	/**
	 * returns the orderby value
	 *
	 * @return string
	 */
	public function getOrderBy() {
		return $this->orderby;
	}

	/**
	 * sets the order direction
	 *
	 * @param string $ordertype either "asc" or "desc"
	 */
	public function setOrderType($ordertype) {
		$this->ordertype = $ordertype;
	}

	/**
	 * returns the order direction
	 * 
	 * @return string
	 */
	public function getOrderType() {
		return $this->ordertype;
	}

	/**
	 * sets orderby & ordertype by passing a domain model Order
	 *
	 * @param Tx_Justimmo_Domain_Model_Order $order
	 * @return void
	 */
	public function setOrder(Tx_Justimmo_Domain_Model_Order $order) {
		$this->setOrderBy($order->getValue());
		$this->setOrderType($order->getDirection());
	}

	/**
	 * returns total_count setting
	 *
	 * @return integer
	 */
	public function getTotalCount() {
		return $this->total_count;
	}
}
?>