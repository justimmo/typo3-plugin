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
 *
 *
 * @package justimmo
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_Justimmo_Domain_Model_Realty extends Tx_Extbase_DomainObject_AbstractEntity {
	/**
	 * holds the SimpleXMLElement result object
	 *
	 * @var SimpleXMLElement
	 */
	protected $xml;

	/**
	 * constructs a Realty object
	 *
	 * Input from the repository is a SimpleXMLElement object
	 *
	 * @param SimpleXMLElement $xml
	 */
	public function __construct($xml) {
		$this->xml = $xml;
	}

	public function getId() {
		return (int) $this->xml->id;
	}

	public function getObjektnummer() {
		return (int) $this->xml->objektnummer;
	}

	public function getTitel() {
		return (string) $this->xml->titel;
	}

	public function getObjektbeschreibung() {
		return (string) $this->xml->objektbeschreibung;
	}

	public function getAnzahl_zimmer() {
		return (int) $this->xml->anzahl_zimmer;
	}

	public function getPlz() {
		return (string) $this->xml->plz;
	}

	public function getOrt() {
		return (string) $this->xml->ort;
	}

	public function getKaufpreis() {
		return (float) $this->xml->kaufpreis;
	}

	public function getGesamtmiete() {
		return (float) $this->xml->gesamtmiete;
	}

	public function getWohnflaeche() {
		return (float) $this->xml->wohnflaeche;
	}

	public function getNutzflaeche() {
		return (float) $this->xml->nutzflaeche;
	}

	public function getErstes_bild() {
		return (string) $this->xml->erstes_bild;
	}
}
?>