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
	 * builds and processes a validator
	 *
	 * Use this to create a simple validator which gets processed with self::processPropertyValidator
	 *
	 * @param object $subject the subject whose property should be validated
	 * @param string $property the property which should be valiadated; use lowerCamelCase
	 * @param string $validatorName the validator name, e.g. Tx_Extbase_Validation_Validator_IntegerValidator
	 * @param array $validatorOptions optional validator options
	 * @return TRUE on successful validation, FALSE otherwise
	 */
	protected function buildAndProcessValidator($subject, $property, $validatorName, $validatorOptions = array()) {
		// expand to extbase internal validator
		if ('Tx_' !== substr($validatorName, 0, 3)) {
			$validatorName = 'Tx_Extbase_Validation_Validator_' . $validatorName;
		}

		$validator = $this->objectManager->get($validatorName);

		if (0 < count($validatorOptions)) {
			$validator->setOptions($validatorOptions);
		}

		$propertyValue = call_user_func(array($subject, 'get'. ucfirst($property)));

		return $this->processPropertyValidator($validator, $propertyValue);
	}

	/**
	 * processes a property validator
	 *
	 * This method processes validation if the given $property is not empty.
	 *
	 * @param Tx_Extbase_Validation_Validator_AbstractValidator $validator
	 * @param mixed $property
	 * @return boolean
	 */
	protected function processPropertyValidator(Tx_Extbase_Validation_Validator_AbstractValidator $validator, $property) {
		if ($property // validation is performed if property is set
			&& !$validator->isValid($property)) {
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

		if (!$this->buildAndProcessValidator($value, 'objektnummer', 'IntegerValidator')) {
			return FALSE;
		}

		$purchaseTypeOptions = array(
			'startRange' => 0,
			'endRange' => 1
		);

		if (!$this->buildAndProcessValidator($value, 'kauf', 'NumberRangeValidator', $purchaseTypeOptions)) {
			return FALSE;
		}

		if (!$this->buildAndProcessValidator($value, 'miete', 'NumberRangeValidator', $purchaseTypeOptions)) {
			return FALSE;
		}

		if (!$this->buildAndProcessValidator($value, 'preisVon', 'FloatValidator')) {
			return FALSE;
		}

		if (!$this->buildAndProcessValidator($value, 'preisBis', 'FloatValidator')) {
			return FALSE;
		}

		if (!$this->buildAndProcessValidator($value, 'zimmerVon', 'IntegerValidator')) {
			return FALSE;
		}

		if (!$this->buildAndProcessValidator($value, 'zimmerBis', 'IntegerValidator')) {
			return FALSE;
		}

		if (!$this->buildAndProcessValidator($value, 'wohnflaecheVon', 'IntegerValidator')) {
			return FALSE;
		}

		if (!$this->buildAndProcessValidator($value, 'wohnflaecheBis', 'IntegerValidator')) {
			return FALSE;
		}

		if (!$this->buildAndProcessValidator($value, 'nutzflaecheVon', 'IntegerValidator')) {
			return FALSE;
		}

		if (!$this->buildAndProcessValidator($value, 'nutzflaecheBis', 'IntegerValidator')) {
			return FALSE;
		}

		if (!$this->buildAndProcessValidator($value, 'grundflaecheVon', 'IntegerValidator')) {
			return FALSE;
		}

		if (!$this->buildAndProcessValidator($value, 'grundflaecheBis', 'IntegerValidator')) {
			return FALSE;
		}

		if (!$this->buildAndProcessValidator($value, 'plzVon', 'IntegerValidator')) {
			return FALSE;
		}

		if (!$this->buildAndProcessValidator($value, 'plzBis', 'IntegerValidator')) {
			return FALSE;
		}

		if (!$this->buildAndProcessValidator($value, 'ort', 'StringValidator')) {
			return FALSE;
		}

		if (!$this->buildAndProcessValidator($value, 'landId', 'IntegerValidator')) {
			return FALSE;
		}

		if (!$this->buildAndProcessValidator($value, 'bundeslandId', 'StringValidator')) {
			return FALSE;
		}

		$objektartIdValidator = $this->objectManager->get('Tx_Extbase_Validation_Validator_IntegerValidator');

		$objektartIds = $value->getObjektartId();
		foreach ($objektartIds as $objektart_id) {
			if (!$this->processPropertyValidator($objektartIdValidator, $objektart_id)) {
				return FALSE;
			}
		}

		$regionValidator = $this->objectManager->get('Tx_Extbase_Validation_Validator_IntegerValidator');

		$regions = $value->getRegion();
		foreach ($regions as $region) {
			if (!$this->processPropertyValidator($regionValidator, $region)) {
				return FALSE;
			}
		}
	}
}
?>