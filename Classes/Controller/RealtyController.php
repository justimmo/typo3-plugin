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
 * controller for realty object based actions
 *
 * This controller encapsulates the realty object base actions list (search
 * results), order (search results ordering), paginate (search results pagination),
 * reset (reset search results filter), show (realty objcet detail) and
 * expose (realty object PDF download).
 *
 * @package justimmo
 * @subpackage Controller
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
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
	 * holds the framework settings
	 *
	 * @var array
	 */
	protected $frameworkSettings;

	/**
	 * holds the view settings
	 *
	 * @var array
	 */
	protected $viewSettings;

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
	 * injects the configuration manager and retrieves the framework settings
	 *
	 * @param Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager
	 * @return void
	 */
	public function injectFrameworkConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager) {
		$this->frameworkSettings = $configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK);
	}

	/**
	 * initializing the controller object
	 *
	 * @return void
	 */
	public function initializeObject() {
		$this->viewSettings = $this->frameworkSettings['view'];
	}

	/**
	 * A special action which is called if the originally intended action could
	 * not be called, for example if the arguments were not valid.
	 *
	 * The default implementation sets a flash message, request errors and forwards back
	 * to the originating action. This is suitable for most actions dealing with form input.
	 *
	 * We clear the page cache by default on an error as well, as we need to make sure the
	 * data is re-evaluated when the user changes something.
	 *
	 * @return string
	 * @api
	 */
	protected function errorAction() {
		$this->request->setErrors($this->argumentsMappingResults->getErrors());
		$this->clearCacheOnError();

		$errorFlashMessage = $this->getErrorFlashMessage();
		if ($errorFlashMessage !== FALSE) {
			$this->flashMessages->add($errorFlashMessage, '', t3lib_FlashMessage::ERROR);
		}

		if ($this->request->hasArgument('__referrer')) {
			$referrer = $this->request->getArgument('__referrer');
			$this->forward($referrer['actionName'], $referrer['controllerName'], $referrer['extensionName'], $this->request->getArguments());
		}

		$message = 'An error occurred while trying to call ' . get_class($this) . '->' . $this->actionMethodName . '().' . PHP_EOL;
		foreach ($this->argumentsMappingResults->getErrors() as $error) {
			$message .= 'Error:   ' . $error->getMessage() . PHP_EOL;
		}
		foreach ($this->argumentsMappingResults->getWarnings() as $warning) {
			$message .= 'Warning: ' . $warning->getMessage() . PHP_EOL;
		}
		return $message;
	}

	/**
	 * action show
	 *
	 * @param integer $id
	 * @param integer $position
	 * @return void
	 * @todo do *NOT* bypass the Repository/hydration functionality of extbase, change param to Tx_Justimmo_Domain_Model_Realty if possible
	 */
	public function showAction($id = NULL, $position = NULL) {
		if (NULL !== $id) {
			$realty = $this->realtyRepository->findById($id);
		}

		if (FALSE === isset($realty) && NULL !== $position) {
			$realty = $this->realtyRepository->findByPosition($position);
		}

		$this->view->assign('position', $position);
		$this->view->assign('prev_position', $position - 1);
		$this->view->assign('next_position', $position + 1);
		$this->view->assign('total_count', $this->realtyRepository->getTotalCount());		

		$this->view->assign('realty', $realty);
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
	 */
	public function listAction(Tx_Justimmo_Domain_Model_Filter $filter = NULL) {
		if (NULL !== $filter) {
			$this->realtyRepository->setFilter($filter->toArray());
		}

		$realties = $this->realtyRepository->findAll();

		$this->realtyRepository->persistListParameters();

		// forward if only one realty (e.g. objektnummer search)
		if (count($realties) == 1) {
			$this->forward('show', NULL, NULL, array('id' => $realties[0]->getId()));
		}

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

		$templatePathAndFilename = t3lib_div::getFileAbsFileName($this->viewSettings['templateRootPath'] . 'Realty/List.html');
		$this->view->setTemplatePathAndFilename($templatePathAndFilename);
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

		$templatePathAndFilename = t3lib_div::getFileAbsFileName($this->viewSettings['templateRootPath'] . 'Realty/List.html');
		$this->view->setTemplatePathAndFilename($templatePathAndFilename);
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

		$templatePathAndFilename = t3lib_div::getFileAbsFileName($this->viewSettings['templateRootPath'] . 'Realty/List.html');
		$this->view->setTemplatePathAndFilename($templatePathAndFilename);
	}
}
?>