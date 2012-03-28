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
 * realurl autoconfiguration class
 * 
 * @package justimmo
 * @subpackage Utility
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @author Thomas Juhnke <tommy@van-tomas.de>
 */
class Tx_Justimmo_Utility_RealurlAutoconfiguration implements t3lib_Singleton {

	/**
	 * adds auto configuration to realurl auto configuration array
	 *
	 * @param array $params array of realurl autoconfiguration parameters
	 * @param tx_realurl_autoconfgen $pObj tx_realurl_autoconfgen parent object
	 * @return array
	 */
	public function addJustimmoConfig($params, &$pObj) {
		$realurlConfiguration = array(
			/**
			 * from realurl manual:
			 * 
			 * Important: The order in which the postVarSets occur is of great 
			 * importance since the first keyword definition that contains a 
			 * definition for a single available GET-var will be chosen. You 
			 * should arrange the postVarSets strategically.
			 */
			'postVarSets' => array(
				'_DEFAULT' => array(
					'objektnummer' => array(
						array(
							'GETvar' => 'tx_justimmo_realtynumbersearch[controller]',
							'noMatch' => 'bypass'
						),
						array(
							'GETvar' => 'tx_justimmo_realtynumbersearch[action]',
							'noMatch' => 'bypass'
						)
					),
					'schnellsuche' => array(
						array(
							'GETvar' => 'tx_justimmo_quicksearch[controller]',
							'noMatch' => 'bypass'
						),
						array(
							'GETvar' => 'tx_justimmo_quicksearch[action]',
							'noMatch' => 'bypass'
						)
					),
					'detailsuche' => array(
						array(
							'GETvar' => 'tx_justimmo_detailsearch[controller]',
							'noMatch' => 'bypass'
						),
						array(
							'GETvar' => 'tx_justimmo_detailsearch[action]',
							'noMatch' => 'bypass'
						)
					),
					'suchergebnisse' => array(
						array(
							'GETvar' => 'tx_justimmo_searchresults[controller]',
							'noMatch' => 'bypass'
						),
						array(
							'GETvar' => 'tx_justimmo_searchresults[action]',
							'valueMap' => array(
								'seite' => 'paginate',
								'alle-immobilien' => 'reset',
								'uebersicht' => 'list',
								'sortieren' => 'order'
							),
						),
						array(
							'GETvar' => 'tx_justimmo_searchresults[order][value]',
							// @see Tx_Justimmo_Domain_Model_Order::$SUPPORTED_ORDER_VALUES
							// @note update this array accordingly as the order values evolves
							'valueMap' => array(
								'ort' => 'ort',
								'kaufpreis' => 'kaufpreis',
								'gesamtmiete' => 'gesamtmiete',
								'wohnflaeche' => 'wohnflaeche',
								'zimmer' => 'zimmer',
								'plz' => 'plz'
							),
							'noMatch' => 'bypass'
						),
						array(
							'GETvar' => 'tx_justimmo_searchresults[order][direction]',
							'valueMap' => array(
								'aufsteigend' => 'asc',
								'absteigend' => 'desc'
							),
							'noMatch' => 'bypass'
						),
						array(
							'GETvar' => 'tx_justimmo_searchresults[page]'
						)
					),
					'immobilie' => array(
						array(
							'GETvar' => 'tx_justimmo_realtydetail[controller]',
							'noMatch' => 'bypass'
						),
						array(
							'GETvar' => 'tx_justimmo_realtydetail[action]',
							'noMatch' => 'bypass'
						),
						array(
							'GETvar' => 'tx_justimmo_realtydetail[id]'
						),
						array(
							'GETvar' => 'tx_justimmo_realtydetail[position]'
						)
					)
				)
			)
		);

		$returnValue = array_merge_recursive(
			$params['config'],
			$realurlConfiguration
		);

		return $returnValue;
	}
}
?>