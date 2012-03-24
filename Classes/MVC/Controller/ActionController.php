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
*  the Free Software Foundation; either version 2 of the License, or
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
 * A multi action controller. This is by far the most common base class for Controllers.
 *
 * @package justimmo
 * @subpackage MVC\Controller
 * @api
 */
class Tx_Justimmo_MVC_Controller_ActionController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * a customized action error handling method
	 *
	 * This method is extended by looking into available translation catalogue
	 * for an action/method related error string. If nothing is found, the original
	 * message is returned.
	 *
	 * @return string
	 * @api
	 */
	protected function errorAction() {
		$message = parent::errorAction();

		$extensionName = $this->extensionName;
		$l10nKey = sprintf('error.%s.%s',
			get_class($this),
			$this->actionMethodName
		);
		$localizedMessage = Tx_Extbase_Utility_Localization::translate($l10nKey, $extensionName);

		if (NULL !== $localizedMessage) {
			$message = $localizedMessage;
		}

		return $message;
	}

	/**
	 * A template method for displaying custom error flash messages, or to
	 * display no flash message at all on errors. Override this to customize
	 * the flash message in your action controller.
	 *
	 * @return string|boolean The flash message or FALSE if no flash message should be set
	 * @api
	 */
	protected function getErrorFlashMessage() {
		$message = parent::getErrorFlashMessage();

		$extensionName = $this->extensionName;
		$l10nKey = sprintf('error.%s.%s',
				get_class($this),
				$this->actionMethodName
		);
		$localizedMessage = Tx_Extbase_Utility_Localization::translate($l10nKey, $extensionName);
		
		if (NULL !== $localizedMessage) {
			$message = $localizedMessage;
		}

		return $message;
	}
}
?>