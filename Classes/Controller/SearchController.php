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
class Tx_Justimmo_Controller_SearchController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 *
	 * @var Tx_Justimmo_Service_JustimmoApiService
	 */
	protected $justimmoApiService;

	/**
	 *
	 * @var Tx_Justimmo_Domain_Repository_RealtyRepository
	 */
	protected $realtyRepository;

	/**
	 * injects the justimmo API service into this controller
	 *
	 * @param Tx_Justimmo_Service_JustimmoApiService $justimmoApiService
	 */
	public function injectJustimmoApiService(Tx_Justimmo_Service_JustimmoApiService $justimmoApiService) {
		$this->justimmoApiService = $justimmoApiService;
	}

	/**
	 * injects the realty repository
	 *
	 * @param Tx_Justimmo_Domain_Repository_RealtyRepository $realtyRepository
	 */
	public function injectRealtyRepository(Tx_Justimmo_Domain_Repository_RealtyRepository $realtyRepository) {
		$this->realtyRepository = $realtyRepository;
	}

	/**
	 * reflects the realty number search
	 *
	 * @param Tx_Justimmo_Domain_Model_Filter $filter
	 * @dontvalidate $filter
	 * @return void
	 */
	public function realtynumberAction(Tx_Justimmo_Domain_Model_Filter $filter = NULL) {
		$this->view->assign('filter', $filter);
	}

	/**
	 * reflects the quick search
	 *
	 * @param Tx_Justimmo_Domain_Model_Filter $filter
	 * @dontvalidate $filter
	 * @return void
	 */
	public function quickAction(Tx_Justimmo_Domain_Model_Filter $filter = NULL) {
		if ($filter === NULL) { // workaround for fluid bug #5636
			/* @var $filter Tx_Justimmo_Domain_Model_Filter */
			$filter = $this->objectManager->get('Tx_Justimmo_Domain_Model_Filter');

			$this->realtyRepository->reconstituteListParameters();
			$filter->fromArray($this->realtyRepository->getFilter());
		}
		$this->view->assign('filter', $filter);
	}

	/**
	 * reflects the direct links search
	 */
	public function directAction() {
	}

	/**
	 * reflects the detail search
	 *
	 * @param Tx_Justimmo_Domain_Model_Filter $filter
	 * @dontvalidate $filter
	 * @return void
	 */
	public function detailAction(Tx_Justimmo_Domain_ModeL_Filter $filter = NULL) {
		if ($filter === NULL) { // workaround for fluid bug #5636
			/* @var $filter Tx_Justimmo_Domain_Model_Filter */
			$filter = $this->objectManager->get('Tx_Justimmo_Domain_Model_Filter');

			$this->realtyRepository->reconstituteListParameters();
			$filter->fromArray($this->realtyRepository->getFilter());
		}

		$regionsInternal = $this->justimmoApiService->getRegions(
			$this->settings['api']['geo']['regions']['defaultCountryIdent']
		);
		$regions = array();
		foreach ($regionsInternal as $region) {
			$regions[] = (array) $region;
		}

		$this->view->assign('filter', $filter);
		$this->view->assign('regions', $regions);
	}
}