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
			$filter = $this->objectManager->get('Tx_Justimmo_Domain_Model_Filter');
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
			$filter = $this->objectManager->get('Tx_Justimmo_Domain_Model_Filter');
		}

		$this->view->assign('filter', $filter);
	}
}