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
 * ViewHelper interface for justimmo geo API
 *
 * @package justimmo
 * @subpackage Core\ViewHelper
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @author Thomas Juhnke <tommy@van-tomas.de>
 */
interface Tx_Justimmo_Core_ViewHelper_JustimmoGeoViewHelperInterface {
	
	/**
	 * this DI method must exist in every justimmo geo VH in order to make usage of the API
	 *
	 * this injection method must set self::$api
	 *
	 * @param Tx_Justimmo_Service_JustimmoApiService $justimmoApiService
	 * @return void
	 */
	public function injectJustimmoApiService(Tx_Justimmo_Service_JustimmoApiService $justimmoApiService);
}
?>