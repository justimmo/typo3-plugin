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
 * @author Thomas Juhnke <tommy@van-tomas.de>
 */
class Tx_Justimmo_Controller_RealtyController extends Tx_Justimmo_MVC_Controller_ActionController {

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

		// page title display option
		if (TRUE === (bool) $this->settings['pageTitle']['enable']) {
			$pagetitleMode = $this->settings['pageTitle']['mode'];
			$currentTitle = $this->getPageTitle();

			switch ($pagetitleMode) {
				case 'before':
					$this->setPageTitle($realty->getObjekttitel() . $currentTitle);
				break;
				case 'after':
					$this->setPageTitle($currentTitle . $realty->getObjekttitel());
				break;
				case 'override':
				default:
					$this->setPageTitle($realty->getObjekttitel());
				break;
			}
		}
	}

	/**
	 * gets the page title of the current page
	 *
	 * The approach how to fetch the title depends on settings.pageTitle.usePageRenderer
	 *
	 * @return string
	 */
	protected function getPageTitle() {
		if (TRUE === (bool) $this->settings['pageTitle']['usePageRenderer']) {
			return $GLOBALS['TSFE']->getPageRenderer()->getTitle();
		} else {
			return $GLOBALS['TSFE']->page['title'];
		}
	}

	/**
	 * sets the page title of the current page
	 *
	 * The approach how to set the title depends on settings.pageTitle.usePageRenderer
	 *
	 * @param string $title
	 * @return false
	 */
	protected function setPageTitle($title) {
		if (TRUE === (bool) $this->settings['pageTitle']['usePageRenderer']) {
			$GLOBALS['TSFE']->getPageRenderer()->setTitle($title);
		} else {
			$GLOBALS['TSFE']->page['title'] = $title;
		}
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
	 * @param Tx_Justimmo_Domain_Model_Order $order
	 * @dontvalidate $order
	 * @dontverifyrequesthash
	 * @return void
	 */
	public function listAction(Tx_Justimmo_Domain_Model_Filter $filter = NULL, Tx_Justimmo_Domain_Model_Order $order = NULL) {
		if (NULL !== $filter) {
			$this->realtyRepository->setFilter($filter->toArray());
		}
		if (NULL === $order) {
			$order = $this->objectManager->create('Tx_Justimmo_Domain_Model_Order');
		}

		try {
			$order->setValue($this->realtyRepository->getOrderBy());
			$order->setDirection($this->realtyRepository->getOrderType());
		} catch (Exception $e) {
		}

		$this->realtyRepository->setOrder($order);
		$this->realtyRepository->setPage(1);

		$realties = $this->realtyRepository->findAll();

		$this->realtyRepository->persistListParameters();

		// forward if only one realty (e.g. objektnummer search)
		if (count($realties) == 1) {
			$this->forward('show', NULL, NULL, array('id' => $realties[0]->getId()));
		}

		$this->view->assign('realties', $realties);
		$this->view->assign('order', $order);

		$this->setPaginationVariables();
	}

	/**
	 * resets API filters
	 *
	 * @return void
	 */
	public function resetAction() {
		$order = $this->objectManager->create('Tx_Justimmo_Domain_Model_Order');

		$this->realtyRepository->resetFilter();

		$realties = $this->realtyRepository->findAll();

		$this->realtyRepository->persistListParameters();

		$this->view->assign('realties', $realties);
		$this->view->assign('order', $order);

		$this->setPaginationVariables();

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
		/* @var $order Tx_Justimmo_Domain_Model_Order */
		$order = $this->objectManager->create('Tx_Justimmo_Domain_Model_Order');

		$this->realtyRepository->setPage($page);

		$realties = $this->realtyRepository->findAll();

		try {
			$order->setValue($this->realtyRepository->getOrderBy());
			$order->setDirection($this->realtyRepository->getOrderType());
		} catch (Exception $e) {
		}

		$this->realtyRepository->persistListParameters();

		$this->view->assign('realties', $realties);
		$this->view->assign('order', $order);

		$this->setPaginationVariables();

		$templatePathAndFilename = t3lib_div::getFileAbsFileName($this->viewSettings['templateRootPath'] . 'Realty/List.html');
		$this->view->setTemplatePathAndFilename($templatePathAndFilename);
	}

	/**
	 * orders the realty object list
	 *
	 * @param Tx_Justimmo_Domain_Model_Order $order
	 * @dontverifyrequesthash
	 * @return void
	 */
	public function orderAction(Tx_Justimmo_Domain_Model_Order $order) {
		$this->realtyRepository->setOrder($order);

		$realties = $this->realtyRepository->findAll();

		$this->realtyRepository->persistListParameters();

		$this->view->assign('realties', $realties);
		$this->view->assign('order', $order);

		$this->setPaginationVariables();

		$templatePathAndFilename = t3lib_div::getFileAbsFileName($this->viewSettings['templateRootPath'] . 'Realty/List.html');
		$this->view->setTemplatePathAndFilename($templatePathAndFilename);
	}

	/**
	 * sets the pagination view variables
	 *
	 * @return void
	 */
	protected function setPaginationVariables() {
		$this->view->assign('pager', array(
			'total_items' => $this->realtyRepository->getTotalCount(),
			'items_per_page' => $this->realtyRepository->getMaxPerPage(),
			'current_page' => $this->realtyRepository->getPage()
		));
	}
}
?>