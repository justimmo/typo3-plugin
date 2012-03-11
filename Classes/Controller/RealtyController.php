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
class Tx_Justimmo_Controller_RealtyController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * realtyRepository
	 *
	 * @var Tx_Justimmo_Domain_Repository_RealtyRepository
	 */
	protected $realtyRepository;

	/**
	 * injectRealtyRepository
	 *
	 * @param Tx_Justimmo_Domain_Repository_RealtyRepository $realtyRepository
	 * @return void
	 */
	public function injectRealtyRepository(Tx_Justimmo_Domain_Repository_RealtyRepository $realtyRepository) {
		$this->realtyRepository = $realtyRepository;
	}

	/**
	 * action show
	 *
	 * @param $realty
	 * @return void
	 */
	public function showAction(Tx_Justimmo_Domain_Model_Realty $realty) {
		$this->view->assign('realty', $realty);
	}

	/**
	 * action list
	 *
	 * @param Tx_Justimmo_Domain_Model_Filter $filter
	 * @return void
	 */
	public function listAction(Tx_Justimmo_Domain_Model_Filter $filter) {
		/*
		$realties = $this->realtyRepository->findAll();
		$this->view->assign('realties', $realties);
		*/

		$this->view->assign('filter', $filter);
	}

}
?>