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
 * filter domain object
 *
 * The filter domain model object defines the available filters of the justimmo
 * API service. This class must be extended if new filters become available or
 * old ones disappear.
 *
 * @package justimmo
 * @subpackage Domain\Model
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_Justimmo_Domain_Model_Filter extends Tx_Extbase_DomainObject_AbstractValueObject {

	/**
	 * objektnummer
	 *
	 * @var integer
	 */
	protected $objektnummer;

	/**
	 * kauf
	 *
	 * @var boolean
	 */
	protected $kauf = FALSE;

	/**
	 * miete
	 *
	 * @var boolean
	 */
	protected $miete = FALSE;

	/**
	 * objektartId
	 *
	 * @var array
	 */
	protected $objektartId = array();

	/**
	 * preisVon
	 *
	 * @var float
	 */
	protected $preisVon;

	/**
	 * preisBis
	 *
	 * @var float
	 */
	protected $preisBis;

	/**
	 * zimmerVon
	 *
	 * @var integer
	 */
	protected $zimmerVon;

	/**
	 * zimmerBis
	 *
	 * @var integer
	 */
	protected $zimmerBis;

	/**
	 * wohnflaecheVon
	 *
	 * @var integer
	 */
	protected $wohnflaecheVon;

	/**
	 * wohnflaecheBis
	 *
	 * @var integer
	 */
	protected $wohnflaecheBis;

	/**
	 * nutzflaecheVon
	 *
	 * @var integer
	 */
	protected $nutzflaecheVon;

	/**
	 * nutzflaecheBis
	 *
	 * @var integer
	 */
	protected $nutzflaecheBis;

	/**
	 * grundflaecheVon
	 *
	 * @var integer
	 */
	protected $grundflaecheVon;

	/**
	 * grundflaecheBis
	 *
	 * @var integer
	 */
	protected $grundflaecheBis;

	/**
	 * plzVon
	 *
	 * @var string
	 */
	protected $plzVon;

	/**
	 * plzBis
	 *
	 * @var string
	 */
	protected $plzBis;

	/**
	 * ort
	 *
	 * @var string
	 */
	protected $ort;

	/**
	 * landId
	 *
	 * @var integer
	 */
	protected $landId;

	/**
	 * land ISO2 code
	 *
	 * @var string
	 */
	protected $landIso2;

	/**
	 * bundeslandId
	 * 
	 * Even it is called "ID", you have to pass a string representation of the
	 * state ("Bundesland")
	 *
	 * @var string
	 */
	protected $bundeslandId;

	/**
	 * region
	 *
	 * @var array
	 */
	protected $region = array();

	/**
	 * Returns the objektnummer
	 *
	 * @return integer objektnummer
	 */
	public function getObjektnummer() {
		return $this->objektnummer;
	}

	/**
	 * Sets the objektnummer
	 *
	 * @param integer $objektnummer
	 * @return integer objektnummer
	 */
	public function setObjektnummer($objektnummer) {
		$this->objektnummer = $objektnummer;
	}

	/**
	 * Returns the kauf
	 *
	 * @return boolean $kauf
	 */
	public function getKauf() {
		return $this->kauf;
	}

	/**
	 * Sets the kauf
	 *
	 * @param boolean $kauf
	 * @return void
	 */
	public function setKauf($kauf) {
		$this->kauf = $kauf;
	}

	/**
	 * Returns the boolean state of kauf
	 *
	 * @return boolean
	 */
	public function isKauf() {
		return $this->getKauf();
	}

	/**
	 * Returns the miete
	 *
	 * @return boolean $miete
	 */
	public function getMiete() {
		return $this->miete;
	}

	/**
	 * Sets the miete
	 *
	 * @param boolean $miete
	 * @return void
	 */
	public function setMiete($miete) {
		$this->miete = $miete;
	}

	/**
	 * Returns the boolean state of miete
	 *
	 * @return boolean
	 */
	public function isMiete() {
		return $this->getMiete();
	}

	/**
	 * Returns the preisVon
	 *
	 * @return float $preisVon
	 */
	public function getPreisVon() {
		return $this->preisVon;
	}

	/**
	 * Sets the preisVon
	 *
	 * @param float $preisVon
	 * @return void
	 */
	public function setPreisVon($preisVon) {
		$this->preisVon = $preisVon;
	}

	/**
	 * Returns the preisBis
	 *
	 * @return float $preisBis
	 */
	public function getPreisBis() {
		return $this->preisBis;
	}

	/**
	 * Sets the preisBis
	 *
	 * @param float $preisBis
	 * @return void
	 */
	public function setPreisBis($preisBis) {
		$this->preisBis = $preisBis;
	}

	/**
	 * Returns the zimmerVon
	 *
	 * @return integer $zimmerVon
	 */
	public function getZimmerVon() {
		return $this->zimmerVon;
	}

	/**
	 * Sets the zimmerVon
	 *
	 * @param integer $zimmerVon
	 * @return void
	 */
	public function setZimmerVon($zimmerVon) {
		$this->zimmerVon = $zimmerVon;
	}

	/**
	 * Returns the zimmerBis
	 *
	 * @return integer $zimmerBis
	 */
	public function getZimmerBis() {
		return $this->zimmerBis;
	}

	/**
	 * Sets the zimmerBis
	 *
	 * @param integer $zimmerBis
	 * @return void
	 */
	public function setZimmerBis($zimmerBis) {
		$this->zimmerBis = $zimmerBis;
	}

	/**
	 * Returns the wohnflaecheVon
	 *
	 * @return integer $wohnflaecheVon
	 */
	public function getWohnflaecheVon() {
		return $this->wohnflaecheVon;
	}

	/**
	 * Sets the wohnflaecheVon
	 *
	 * @param integer $wohnflaecheVon
	 * @return void
	 */
	public function setWohnflaecheVon($wohnflaecheVon) {
		$this->wohnflaecheVon = $wohnflaecheVon;
	}

	/**
	 * Returns the wohnflaecheBis
	 *
	 * @return string $wohnflaecheBis
	 */
	public function getWohnflaecheBis() {
		return $this->wohnflaecheBis;
	}

	/**
	 * Sets the wohnflaecheBis
	 *
	 * @param string $wohnflaecheBis
	 * @return void
	 */
	public function setWohnflaecheBis($wohnflaecheBis) {
		$this->wohnflaecheBis = $wohnflaecheBis;
	}

	/**
	 * Returns the nutzflaecheVon
	 *
	 * @return integer $nutzflaecheVon
	 */
	public function getNutzflaecheVon() {
		return $this->nutzflaecheVon;
	}

	/**
	 * Sets the nutzflaecheVon
	 *
	 * @param integer $nutzflaecheVon
	 * @return void
	 */
	public function setNutzflaecheVon($nutzflaecheVon) {
		$this->nutzflaecheVon = $nutzflaecheVon;
	}

	/**
	 * Returns the nutzflaecheBis
	 *
	 * @return string $nutzflaecheBis
	 */
	public function getNutzflaecheBis() {
		return $this->nutzflaecheBis;
	}

	/**
	 * Sets the nutzflaecheBis
	 *
	 * @param string $nutzflaecheBis
	 * @return void
	 */
	public function setNutzflaecheBis($nutzflaecheBis) {
		$this->nutzflaecheBis = $nutzflaecheBis;
	}

	/**
	 * Returns the grundflaecheVon
	 *
	 * @return integer $grundflaecheVon
	 */
	public function getGrundflaecheVon() {
		return $this->grundflaecheVon;
	}

	/**
	 * Sets the grundflaecheVon
	 *
	 * @param integer $grundflaecheVon
	 * @return void
	 */
	public function setGrundflaecheVon($grundflaecheVon) {
		$this->grundflaecheVon = $grundflaecheVon;
	}

	/**
	 * Returns the grundflaecheBis
	 *
	 * @return string $grundflaecheBis
	 */
	public function getGrundflaecheBis() {
		return $this->grundflaecheBis;
	}

	/**
	 * Sets the grundflaecheBis
	 *
	 * @param string $grundflaecheBis
	 * @return void
	 */
	public function setGrundflaecheBis($grundflaecheBis) {
		$this->grundflaecheBis = $grundflaecheBis;
	}

	/**
	 * Returns the plzVon
	 *
	 * @return string $plzVon
	 */
	public function getPlzVon() {
		return $this->plzVon;
	}

	/**
	 * Sets the plzVon
	 *
	 * @param string $plzVon
	 * @return void
	 */
	public function setPlzVon($plzVon) {
		$this->plzVon = $plzVon;
	}

	/**
	 * Returns the plzBis
	 *
	 * @return string $plzBis
	 */
	public function getPlzBis() {
		return $this->plzBis;
	}

	/**
	 * Sets the plzBis
	 *
	 * @param string $plzBis
	 * @return void
	 */
	public function setPlzBis($plzBis) {
		$this->plzBis = $plzBis;
	}

	/**
	 * Returns the ort
	 *
	 * @return string $ort
	 */
	public function getOrt() {
		return $this->ort;
	}

	/**
	 * Sets the ort
	 *
	 * @param string $ort
	 * @return void
	 */
	public function setOrt($ort) {
		$this->ort = $ort;
	}

	/**
	 * Returns the landId
	 *
	 * @return integer $landId
	 */
	public function getLandId() {
		return $this->landId;
	}

	/**
	 * Sets the landId
	 *
	 * @param integer $landId
	 * @return void
	 */
	public function setLandId($landId) {
		$this->landId = $landId;
	}

	/**
	 * returns the land ISO2 code
	 *
	 * @return string
	 */
	public function getLandIso2() {
		return $this->landIso2;
	}

	/**
	 * sets the land ISO2 code
	 *
	 * @param string $landIso2
	 */
	public function setLandIso2($landIso2) {
		$this->landIso2 = $landIso2;
	}

	/**
	 * Returns the bundesland ID
	 *
	 * @return string
	 */
	public function getBundeslandId() {
		return $this->bundeslandId;
	}

	/**
	 * Sets the bundesland ID
	 *
	 * @param string $bundeslandId
	 * @return void
	 */
	public function setBundeslandId($bundeslandId) {
		$this->bundeslandId = $bundeslandId;
	}

	/**
	 * Returns the region IDs
	 *
	 * @return array $region
	 */
	public function getRegion() {
		return $this->region;
	}

	/**
	 * Sets the region IDs
	 *
	 * @param array $region
	 * @return void
	 */
	public function setRegion($region) {
		$this->region = $region;
	}

	/**
	 * Returns the objektartId
	 *
	 * @return array objektartId
	 */
	public function getObjektartId() {
		return $this->objektartId;
	}

	/**
	 * Sets the objektartId
	 *
	 * @param array $objektartId
	 * @return void
	 */
	public function setObjektartId($objektartId) {
		$this->objektartId = $objektartId;
	}

	/**
	 * converts the filter to an array
	 *
	 * This method converts the Filter object into an array which can be passed
	 * directly into the justimmo API service.
	 *
	 * @return array
	 */
	public function toArray() {
		// skip TYPO3 internal properties
		$skip = array(
			'uid',
			'_localizedUid',
			'_languageUid',
			'pid'
		);

		$filterArray = array();

		foreach ($this as $key => $value) {
			if (TRUE === in_array($key, $skip)) {
				continue;
			}			

			$normalizedKey = t3lib_div::camelCaseToLowerCaseUnderscored($key);

			// skip land_iso2 filter key if value is empty... (empty API response otherwise)
			if ('land_iso2' === $normalizedKey && FALSE !== empty($value)) {
				continue;
			}

			$filterArray[$normalizedKey] = $value;
		}

		return $filterArray;
	}

	/**
	 * allows re-populating a filter domain object from an array of filter properties
	 *
	 * @param array $filterProperties array of filter properties, created with self::toArray()
	 * @return void
	 * @todo: switch to Reflection API if possible, see workaround for kauf/miete properties
	 */
	public function fromArray($filterProperties) {
		// skip TYPO3 internal properties
		$skip = array(
			'uid',
			'_localizedUid',
			'_languageUid',
			'pid'
		);

		foreach ($filterProperties as $filterProperty => $filterPropertyValue) {
			$filterPropertyCamelized = t3lib_div::underscoredToLowerCamelCase($filterProperty);

			if (TRUE === in_array($filterProperty, $skip)
				|| TRUE === in_array($filterPropertyCamelized, $skip)) {
				continue;
			}

			$filterPropertySetter = 'set'. t3lib_div::underscoredToUpperCamelCase($filterProperty);

			// @see http://de.php.net/manual/en/function.property-exists.php#97538
			// for a PHP4 @see http://de.php.net/manual/en/function.property-exists.php#66969
			// 		array_key_exists('propertyName',get_object_vars($myObj))
			$propertyExists = isset($this->$filterPropertyCamelized) || property_exists($this, $filterPropertyCamelized);
			$setterExists = method_exists($this, $filterPropertySetter);
			$valueIsSet = FALSE === empty($filterPropertyValue);

			if ('kauf' === $filterProperty
				|| 'miete' === $filterProperty) {
				$filterPropertyValue = (boolean) $filterProperty;
			}

			if ($propertyExists && $setterExists && $valueIsSet) {
				$this->$filterPropertySetter($filterPropertyValue);
			}
		}
	}
}
?>