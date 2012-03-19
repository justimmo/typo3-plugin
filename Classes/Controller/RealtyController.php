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
	 * justimmo API service
	 *
	 * @var Tx_Justimmo_Service_JustimmoApiService
	 */
	protected $justimmoApiService;

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
	 * injects the justimmo API service
	 *
	 * @param Tx_Justimmo_Service_JustimmoApiService $justimmoApiService
	 */
	public function injectJustimmoApiService(Tx_Justimmo_Service_JustimmoApiService $justimmoApiService) {
		$this->justimmoApiService = $justimmoApiService;
	}

	/**
	 * action show
	 *
	 * @param integer $realty
	 * @return void
	 * @todo do *NOT* bypass extbases's Repository/hydration functionality, change param to Tx_Justimmo_Domain_Model_Realty if possible
	 */
	public function showAction($realty) {
		$realty = $this->realtyRepository->findById($realty);

		$this->view->assign('realty', $realty);
	}

	/**
	 * action position
	 *
	 * Fetches a realty by position
	 *
	 * @param integer $position
	 * @return void
	 */
	public function showPositionAction($position) {
		$realty = $this->realtyRepository->findByPosition($position);

		$this->view->assign('realty', $realty);

		$this->view->setTemplatePathAndFilename(t3lib_extMgm::extPath('justimmo') . 'Resources/Private/Templates/Realty/Show.html');
	}

	/**
	 * sends a PDF expose download to the browser
	 *
	 * @param integer $id
	 */
	public function exposeAction($id) {
		header('Content-type: application/pdf');
		header('Content-Disposition: attachment; filename="expose-' . $id . '-' .time() . '.pdf"');
		
		echo $this->justimmoApiService->getExpose($id);
		exit();
	}

	/**
	 * action list
	 *
	 * @param Tx_Justimmo_Domain_Model_Filter $filter
	 * @return void
	 * @todo implement reset, page, orderby params
	 */
	public function listAction(Tx_Justimmo_Domain_Model_Filter $filter) {
		$this->realtyRepository->setFilter($filter->toArray());

		$realties = $this->realtyRepository->findAll();

		$this->realtyRepository->persistListParameters();

		$this->view->assign('realties', $realties);

		// pagination variables
		$this->view->assignMultiple(array(
			'total_count' => $this->realtyRepository->getTotalCount(),
			'current_page' => $this->realtyRepository->getPage(),
			'previous_page' => $this->realtyRepository->getPreviousPage(),
			'next_page' => $this->realtyRepository->getNextPage(),
			'last_page' => $this->realtyRepository->getLastPage(),
			'is_pageable' => $this->realtyRepository->isPageable(),
			'is_pageable_next_page' => $this->realtyRepository->isPageable(TRUE)
		));
	}

	/**
	 * resets API filters
	 *
	 * @return void
	 */
	public function resetAction() {
		$this->realtyRepository->resetFilter();

		$realties = $this->realtyRepository->findAll();

		$this->realtyRepository->persistListParameters();

		$this->view->assign('realties', $realties);

		// pagination variables
		$this->view->assignMultiple(array(
			'total_count' => $this->realtyRepository->getTotalCount(),
			'current_page' => $this->realtyRepository->getPage(),
			'previous_page' => $this->realtyRepository->getPreviousPage(),
			'next_page' => $this->realtyRepository->getNextPage(),
			'last_page' => $this->realtyRepository->getLastPage(),
			'is_pageable' => $this->realtyRepository->isPageable(),
			'is_pageable_next_page' => $this->realtyRepository->isPageable(TRUE)
		));

		$this->view->setTemplatePathAndFilename(t3lib_extMgm::extPath('justimmo') . 'Resources/Private/Templates/Realty/List.html');
	}

	/**
	 * paginates the realty object list
	 *
	 * @param integer $page
	 * @return void
	 */
	public function paginateAction($page) {
		$this->realtyRepository->setPage($page);

		$realties = $this->realtyRepository->findAll();

		$this->realtyRepository->persistListParameters();

		$this->view->assign('realties', $realties);

		// pagination variables
		$this->view->assignMultiple(array(
			'total_count' => $this->realtyRepository->getTotalCount(),
			'current_page' => $this->realtyRepository->getPage(),
			'previous_page' => $this->realtyRepository->getPreviousPage(),
			'next_page' => $this->realtyRepository->getNextPage(),
			'last_page' => $this->realtyRepository->getLastPage(),
			'is_pageable' => $this->realtyRepository->isPageable(),
			'is_pageable_next_page' => $this->realtyRepository->isPageable(TRUE)
		));

		$this->view->setTemplatePathAndFilename(t3lib_extMgm::extPath('justimmo') . 'Resources/Private/Templates/Realty/List.html');
	}

	/**
	 * orders the realty object list
	 *
	 * @param string $order
	 * @param string $direction order direction ("asc" or "desc"), defaults to "desc"
	 * @return void
	 */
	public function orderAction($order, $direction = 'desc') {
		$this->realtyRepository->setOrderBy($order);

		$realties = $this->realtyRepository->findAll();

		$this->view->assign('realties', $realties);

		// pagination variables
		$this->view->assignMultiple(array(
			'total_count' => $this->realtyRepository->getTotalCount(),
			'current_page' => $this->realtyRepository->getPage(),
			'previous_page' => $this->realtyRepository->getPreviousPage(),
			'next_page' => $this->realtyRepository->getNextPage(),
			'last_page' => $this->realtyRepository->getLastPage(),
			'is_pageable' => $this->realtyRepository->isPageable(),
			'is_pageable_next_page' => $this->realtyRepository->isPageable(TRUE)
		));

		$this->view->setTemplatePathAndFilename(t3lib_extMgm::extPath('justimmo') . 'Resources/Private/Templates/Realty/List.html');
	}
}
?>