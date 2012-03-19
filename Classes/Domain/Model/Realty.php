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
 * Basically, this model object maps the most important data from the SimpleXMLElement
 * object to some extbase/fluid compatible getters.
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

		$this->uid = (int) $this->xml->id;
	}

	/* list information getters - START */

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

	/* list information getters - END */

	/* detail information getters - START */

	public function getNbAnhaenge() {
		return count((array) $this->xml->anhaenge);
	}

	public function getAnhaenge() {
		$anhaengeInternal = (array) $this->xml->anhaenge;

		// simple but sufficient mapping of attachment data
		$anhaenge = array();
		foreach ($anhaengeInternal['anhang'] as $anhang) {
			$anhaenge[] = array(
				'daten' => array(
					'pfad' => (string) $anhang->daten->pfad,
					'small' => (string) $anhang->daten->small,
					'medium' => (string) $anhang->daten->medium,
					'big2' => (string) $anhang->daten->big2,
					'medium2' => (string) $anhang->daten->medium2
				)
			);
		}

		return $anhaenge;
	}

	public function getNbDokumente() {
		return count((array) $this->xml->dokumente);
	}

	public function getDokumente() {
		$dokumenteInternal = (array) $this->xml->dokumente;

		// simple, but sufficient mapping of document data
		$dokumente = array();
		foreach ($dokumenteInternal as $dokument) {
			$dokumente[] = (array) $dokument;
		}

		return $dokumente;
	}

	public function getObjektart() {
		return (string) $this->xml->objektkategorie->objektart->children()->getName();
	}

	public function getObjektartNormalized() {
		$internalType = $this->getObjektart();

		$type = '';

		switch ($internalType) {
			case "haus":
				$type = 'Haus';
			break;
			default:
				$type = 'Wohnung';
			break;
		}

		return $type;
	}

	public function getNbNutzungsart() {
		return (int) count($this->xml->objektkategorie->nutzungsart);
	}

	public function getIsNutzungsartWohnen() {
		return $this->xml->objektkategorie->nutzungsart['WOHNEN'] == 1;
	}

	public function getIsNutzungsartGewerbe() {
		return $this->xml->objektkategorie->nutzungsart['GEWERBE'] == 1;
	}

	public function getIsNutzungsartAnlage() {
		return $this->xml->objektkategorie->nutzungsart['ANLAGE'] == 1;
	}

	public function getObjektnrExtern() {
		return (string) $this->xml->verwaltung_techn->objektnr_extern;
	}

	public function getPreise() {
		return (array) $this->xml->preise;
	}

	public function getNettomiete() {
		$returnValue = 0.0;

		if (isset($this->xml->preise->nettokaltmiete) && $this->xml->preise->nettokaltmiete > 0) {
			$returnValue = (float) $this->xml->preise->nettokaltmiete;
		} elseif ($this->xml->preise->kaltmiete) {
			$returnValue = (float) $this->xml->preise->kaltmiete;
		}

		return $returnValue;
	}

	public function getHasAusstattungsBeschreibung($minimumLength = 2) {
		if (strlen(trim($this->xml->freitexte->ausstatt_beschr)) > $minimumLength) {
			return TRUE;
		}

		return FALSE;
	}

	public function getHasTelefonZentrale() {
		return ($this->xml->kontaktperson->tel_zentrale && $this->xml->kontaktperson->tel_zentrale != 0);
	}

	public function getHasTelefonHandy() {
		return ($this->xml->kontaktperson->tel_handy && $this->xml->kontaktperson->tel_handy != 0);
	}

	public function getHasFax() {
		return ($this->xml->kontaktperson->tel_fax && $this->xml->kontaktperson->tel_fax != 0);
	}

	public function getGeo() {
		return (array) $this->xml->geo;
	}

	public function getFreitexte() {
		return (array) $this->xml->freitexte;
	}

	public function getZustand_angaben() {
		return (array) $this->xml->zustand_angaben;
	}

	public function getFlaechen() {
		return (array) $this->xml->flaechen;
	}

	public function getKontaktperson() {
		return (array) $this->xml->kontaktperson;
	}

	public function getVerwaltung_techn() {
		return (array) $this->xml->verwaltung_techn;
	}

	/* detail information getters - END */
}
?>