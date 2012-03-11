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
 * domain model object validator
 *
 * @package justimmo
 * @subpackage Domain\Validator
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 *
 */
class Tx_Justimmo_Domain_Validator_FilterValidator extends Tx_Extbase_Validation_Validator_AbstractValidator {
	
	/**
	 * object manager instance
	 *
	 * @var Tx_Extbase_Object_ObjectManager
	 */
	protected $objectManager;
	
	/**
	 * injects object manager
	 *
	 * @param Tx_Extbase_Object_ObjectManager $objectManager
	 */
	public function injectObjectManager(Tx_Extbase_Object_ObjectManager $objectManager) {
		$this->objectManager = $objectManager;
	}

	/**
	 * processes a property validator
	 *
	 * This method only validates if the given $property is not empty.
	 *
	 * @param Tx_Extbase_Validation_Validator_AbstractValidator $validator
	 * @param mixed $property
	 * @return boolean
	 */
	protected function processPropertyValidator(Tx_Extbase_Validation_Validator_AbstractValidator $validator, $property) {
		if ($property && !$validator->isValid($property)) {
			$errors = $validator->getErrors();
			foreach ($errors as $error) {
				$this->addError($error->getMessage(), $error->getCode());
			}

			return FALSE;
		}

		return TRUE;
	}

	/**
	 * validates the incoming filter object
	 *
	 * @param Tx_Justimmo_Domain_Model_Filter $value
	 * @return boolean
	 */
	public function isValid($value) {
		if (!is_a($value, 'Tx_Justimmo_Domain_Model_Filter')) {
			$msg = sprintf('Given object (%s) is not of expected type (Tx_Justimmo_Domain_Model_Filter)!', get_class($value));
			$this->addError($msg, 1331479598);

			return FALSE;
		}

		$objektnummerValidator = $this->objectManager->get('Tx_Extbase_Validation_Validator_IntegerValidator');

		if (!$this->processPropertyValidator($objektnummerValidator, $value->getObjektnummer())) {
			return FALSE;
		}

		$kaufValidator = $this->objectManager->get('Tx_Extbase_Validation_Validator_NumberRangeValidator');
		/* @var $kaufValidator Tx_Extbase_Validation_Validator_NumberRangeValidator */
		$kaufValidator->setOptions(array(
			'startRange' => 0,
			'endRange' => 1
		));

		if (!$this->processPropertyValidator($kaufValidator, $value->getKauf())) {
			return FALSE;
		}

		$mieteValidator = $this->objectManager->get('Tx_Extbase_Validation_Validator_NumberRangeValidator');
		/* @var $mieteValidator Tx_Extbase_Validation_Validator_NumberRangeValidator */
		$mieteValidator->setOptions(array(
			'startRange' => 0,
			'endRange' => 1
		));

		if (!$this->processPropertyValidator($mieteValidator, $value->getMiete())) {
			return FALSE;
		}

		$preisVonValidator = $this->objectManager->get('Tx_Extbase_Validation_Validator_FloatValidator');

		if (!$this->processPropertyValidator($preisVonValidator, $value->getPreisVon())) {
			return FALSE;
		}

		$preisBisValidator = $this->objectManager->get('Tx_Extbase_Validation_Validator_FloatValidator');

		if (!$this->processPropertyValidator($preisBisValidator, $value->getPreisBis())) {
			return FALSE;
		}

		$zimmerVonValidator = $this->objectManager->get('Tx_Extbase_Validation_Validator_IntegerValidator');

		if (!$this->processPropertyValidator($zimmerVonValidator, $value->getZimmerVon())) {
			return FALSE;
		}

		$zimmerBisValidator = $this->objectManager->get('Tx_Extbase_Validation_Validator_IntegerValidator');

		if (!$this->processPropertyValidator($zimmerBisValidator, $value->getZimmerBis())) {
			return FALSE;
		}

		$wohnflaecheVonValidator = $this->objectManager->get('Tx_Extbase_Validation_Validator_IntegerValidator');

		if (!$this->processPropertyValidator($wohnflaecheVonValidator, $value->getWohnflaecheVon())) {
			return FALSE;
		}

		$wohnflaecheBisValidator = $this->objectManager->get('Tx_Extbase_Validation_Validator_IntegerValidator');

		if (!$this->processPropertyValidator($wohnflaecheBisValidator, $value->getWohnflaecheBis())) {
			return FALSE;
		}

		$plzVonValidator = $this->objectManager->get('Tx_Extbase_Validation_Validator_IntegerValidator');

		if (!$this->processPropertyValidator($plzVonValidator, $value->getPlzVon())) {
			return FALSE;
		}

		$plzBisValidator = $this->objectManager->get('Tx_Extbase_Validation_Validator_IntegerValidator');

		if (!$this->processPropertyValidator($plzBisValidator, $value->getPlzBis())) {
			return FALSE;
		}

		$ortValidator = $this->objectManager->get('Tx_Extbase_Validation_Validator_StringValidator');

		if (!$this->processPropertyValidator($ortValidator, $value->getOrt())) {
			return FALSE;
		}
	}
}
?>