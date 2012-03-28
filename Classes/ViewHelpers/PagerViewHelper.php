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
 * a pager view helper
 *
 * This view helper supports the templates by providing a simple interface for
 * creating a pager widget. Note, that it only sets some basic variables and the
 * pages array while respecting a maxBefore/maxAfter setting to cut off big
 * pages amounts. The rendering itself must be build inside the children of the
 * view helper tag, e.g setting links, decide if a navigational element should
 * be displayed etc.
 *
 * @package justimmo
 * @subpackage ViewHelpers
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Thomas Juhnke <tommy@van-tomas.de>
 */
class Tx_Justimmo_ViewHelpers_PagerViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {
	/**
	 * holds the page configuration
	 *
	 * The configuration must reside in plugin.tx_EXTKEY.settings.pager
	 *
	 * @var array
	 */
	protected $settings = array();

	/**
	 * holds the amount of total items of the pager
	 *
	 * @var integer
	 */
	protected $totalItems = 0;

	/**
	 * holds the amount of items per page
	 *
	 * @var integer
	 */
	protected $itemsPerPage = 0;

	/**
	 * holds the current page index
	 *
	 * @var integer
	 */
	protected $currentPage = 0;

	/**
	 * holds the amount of total pages
	 *
	 * @var itneger
	 */
	protected $pagesTotal = 0;

	/**
	 * flag which defines if the pager is pageable in all or not (e.g. only 1 page)
	 *
	 * @var boolean
	 */
	protected $isPageable = FALSE;

	/**
	 * flag which defines if the pager is pageable into the next/last page
	 *
	 * @var boolean
	 */
	protected $isPageableNextPage = FALSE;

	/**
	 * injects the configuration manager for retrieving the pager settings
	 *
	 * @param Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager
	 * @return void
	 */
	public function injectConfigurationManager(Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager) {
		$configuration = $configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS);

		$this->settings = $configuration['pager'];
	}

	/**
	 * initializes the view helper arguments
	 * 
	 * Currently, the only argument is "pager" which must consist of the following
	 * items set: "total_items", "items_per_page" & "current_page"
	 * 
	 * @return void
	 */
	public function initializeArguments() {
		$this
			->registerArgument('pager', 'array', 'A pager configuration array.', TRUE);
	}

	/**
	 * initializes the view helper
	 *
	 * The initialization method checks for some necessary set up values and
	 * calculates some specific values like "totalPages" and set flags like
	 * "isPageable" and "isPageableNextPage". Furthermore, it falls back to
	 * some senseful defaults for the pager TS settings
	 *
	 * @return void
	 * @throws Tx_Fluid_Exception if some configuration setting in the pager argument are missing
	 */
	public function initialize() {
		$pager = $this->arguments->offsetGet('pager');

		if (FALSE === isset($pager['total_items'])) {
			throw new Tx_Fluid_Exception('The given pager misses the "total_items" configration.', 1332599565);
		}
		$this->totalItems = (int) $pager['total_items'];

		if (FALSE === isset($pager['items_per_page'])) {
			throw new Tx_Fluid_Exception('The given pager misses the "items_per_page" configuration.', 1332599411);
		}
		$this->itemsPerPage = (int) $pager['items_per_page'];

		if (FALSE === isset($pager['current_page'])) {
			throw new Tx_Fluid_Exception('The given pager misses the "current_page" configuration.', 1332599420);
		}
		$this->currentPage = (int) $pager['current_page'];

		$this->totalPages = ceil($this->totalItems / $this->itemsPerPage);
		$this->isPageable = $this->totalPages > 1;
		$this->isPageableNextPage = $this->totalPages > $this->currentPage;

		if (3 > (int) $this->settings['maxBefore']) {
			$this->settings['maxBefore'] = 3;
		}
		if (3 > (int) $this->settings['maxAfter']) {
			$this->settings['maxAfter'] = 3;
		}
	}

	/**
	 * the render method
	 *
	 * The render method adds some variables to the template variable container
	 * and builds the pages array. After that, parent::renderChildren() is called
	 * and returned so the rendering is actually defined in the children of
	 * the pager view helper
	 *  
	 * @return mixed the finally rendered child nodes
	 */
	public function render() {
		$this->templateVariableContainer->add('isPageable', $this->isPageable);
		$this->templateVariableContainer->add('isPageableNextPage', $this->isPageableNextPage);
		$this->templateVariableContainer->add('previousPage', $this->currentPage - 1);
		$this->templateVariableContainer->add('currentPage', $this->currentPage);
		$this->templateVariableContainer->add('nextPage', $this->currentPage + 1);
		$this->templateVariableContainer->add('totalPages', $this->totalPages);

		$pages = array();
		$hasPlaceholderBefore = $hasPlaceholderAfter = FALSE;
		for ($i = 1; $i <= $this->totalPages; $i++) {
			if ($i === 1 || $i === $this->pagesTotal) {
				$pages[] = $i;
				continue;
			}

			if ($i < ($this->currentPage - $this->settings['maxBefore'])) {
				if (!$hasPlaceholderBefore) {
					$pages[] = '...';
					$hasPlaceholderBefore = TRUE;
				}
				continue;
			}

			if ($i > ($this->currentPage + $this->settings['maxAfter'])) {
				if (!$hasPlaceholderAfter) {
					$pages[] = '...';
					$hasPlaceholderAfter = TRUE;
				}
				continue;
			}

			$pages[] = $i;
		}

		$this->templateVariableContainer->add('pages', $pages);
		

		return $this->renderChildren();
	}
}
?>