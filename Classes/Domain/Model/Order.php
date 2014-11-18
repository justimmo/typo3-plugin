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
 * The order domain object
 *
 * This domain object is needed for passing ordering information to the justimmo
 * API. This consists of a "value" (the order "column") and a direction.
 *
 * @package justimmo
 * @subpackage Domain\Model
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Thomas Juhnke <tommy@van-tomas.de>
 * @api
 */
class Tx_Justimmo_Domain_Model_Order extends Tx_Extbase_DomainObject_AbstractValueObject {

	/**
	 * the API supported order values
	 *
	 * @var array
	 */
	protected static $SUPPORTED_ORDER_VALUES = array(
        'objektnummer',
		'ort',
		'kaufpreis',
		'gesamtmiete',
		'wohnflaeche',
		'zimmer',
		'plz'
	);

	/**
	 * holds the order value
	 *
	 * Either empty or a lowercase_underscored API supported order value
	 * @var string
	 */
	protected $value;

	/**
	 * holds the order direction
	 *
	 * Either empty or "asc" or "desc.
	 *
	 * @var string
	 */
	protected $direction = '';

	/**
	 * returns the order value
	 *
	 * @return string
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * sets the order value
	 *
	 * @param string $value
	 * @throws InvalidArgumentException if given value is not one of supported order values
	 */
	public function setValue($value) {
		if ('' === $value) {
			return NULL;
		}

		if (FALSE === in_array($value, self::$SUPPORTED_ORDER_VALUES)) {
			throw new InvalidArgumentException('The given value "' . $value . '" is currently not supported.', 1332533041);
		}

		$this->value = $value;
	}

	/**
	 * returns the order direction
	 *
	 * @return string
	 */
	public function getDirection() {
		return $this->direction;
	}

	/**
	 * returns the opposite direction of the order
	 *
	 * @return string
	 * @api
	 */
	public function getOppositeDirection() {
		$this->direction = $this->direction == 'desc' ? 'asc' : 'desc';
	}

	/**
	 * sets the order direction
	 *
	 * @param string $direction
	 * @throws InvalidArgumentException if given direction is not "asc" nor "desc"
	 */
	public function setDirection($direction) {
		if (empty($direction)) {
			return NULL;
		}

		if ('asc' !== $direction && 'desc' !== $direction) {
			throw new InvalidArgumentException('The given direction "' . $direction . '" is not supported.', 1332533156);
		}

		$this->direction = $direction;
	}

	/**
	 * dispatches magic methods
	 *
	 * Supported methods:
	 *  - getIsOrderedBy[Order-By-Value], e.g. getIsOrderedByOrt
	 *
	 * @param string $methodName The name of the magic method
	 * @param array $arguments The arguments of the magic method
	 * @return mixed
	 * @throws BadMethodCallException if magic method isn't implemented
	 * @api
	 */
	/*
	public function __call($methodName, $arguments) {
		// allows calls like {order.isOrderedByOrt} in fluid templates or
		// $order->getIsOrderedByOrt() from controllers or other domain objects
		if (substr($methodName, 0, 14) === 'getIsOrderedBy' && strlen($methodName) > 14) 
		{
			// returns "ort" or "kaufpreis" or "anzahl_zimmer"
			$valueName = t3lib_div::camelCaseToLowerCaseUnderscored(substr($methodName, 14));

			#return $this->value === $valueName;
		}

		throw new BadMethodCallException('The method "' . $methodName . '" is not supported by the domain object.', 1332532032);
	}
	*/
}
?>
