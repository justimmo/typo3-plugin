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
 * realty domain model object
 *
 * Basically, this model object maps the most important data from the
 * SimpleXMLElement object to some extbase/fluid compatible getters.
 *
 * @package justimmo
 * @subpackage Domain\Model
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @author Thomas Juhnke <tommy@van-tomas.de>
 */
class Tx_Justimmo_Domain_Model_Realty extends Tx_Extbase_DomainObject_AbstractEntity {

	/**
	 * holds the SimpleXMLElement result object
	 *
	 * @var SimpleXMLElement
	 */
	protected $xml;

	/**
	 * holds the position of the realty in the list of realty objects of the current API query
	 *
	 * @var integer
	 */
	protected $position;

	/**
	 * constructs a Realty object
	 *
	 * Input from the repository is a SimpleXMLElement object
	 *
	 * @param SimpleXMLElement $xml
	 * @return void
	 */
	public function __construct($xml) {
		$this->xml = $xml;

		$this->uid = (int) $this->xml->id;
	}

	/**
	 * sets the position property
	 *
	 * @param integer $position
	 */
	public function setPosition($position) {
		$this->position = $position;
	}

	/**
	 * returns the position property
	 *
	 * @return integer
	 */
	public function getPosition() {
		return $this->position;
	}

	/* list information getters - START */

	/**
	 * returns the ID
	 *
	 *Only available in the search results list view
	 *
	 * @return integer
	 */
	public function getId() {
		return (integer) $this->xml->id;
	}

	/**
	 * returns the object number
	 *
	 * Only available in the search results view
	 *
	 * @return integer
	 */
	public function getObjektnummer() {
		return (integer) $this->xml->objektnummer;
	}

	/**
	 * returns the title
	 *
	 * Only available in the search results view
	 *
	 * @return string
	 */
	public function getTitel() {
		return (string) $this->xml->titel;
	}

	/**
	 * returns the object description
	 *
	 * Only available in the search results view
	 *
	 * @return string
	 */
	public function getObjektbeschreibung() {
		return (string) $this->xml->objektbeschreibung;
	}

	/**
	 * returns amount of rooms
	 *
	 * Only available in search results view
	 *
	 * @return integer
	 */
	public function getAnzahl_zimmer() {
		return (integer) $this->xml->anzahl_zimmer;
	}

	/**
	 * returns the zip code
	 *
	 * Only available in search results view
	 *
	 * @return string
	 */
	public function getPlz() {
		return (string) $this->xml->plz;
	}

	/**
	 * returns the city
	 *
	 * Only available in search results view
	 *
	 * @return string
	 */
	public function getOrt() {
		return (string) $this->xml->ort;
	}

	/**
	 * returns the purchase price
	 *
	 * Only available in search results view
	 *
	 * @return float
	 */
	public function getKaufpreis() {
		return (float) $this->xml->kaufpreis;
	}

	/**
	 * returns total rental fee
	 *
	 * Only available in search results view
	 *
	 * @return float
	 */
	public function getGesamtmiete() {
		return (float) $this->xml->gesamtmiete;
	}

	/**
	 * returns living space
	 *
	 * Only available in search results view
	 *
	 * @return float
	 */
	public function getWohnflaeche() {
		return (float) $this->xml->wohnflaeche;
	}

	/**
	 * returns usable area
	 *
	 * Only available in search results view
	 *
	 * @return float
	 */
	public function getNutzflaeche() {
		return (float) $this->xml->nutzflaeche;
	}

	/**
	 * returns ground space
	 *
	 * Only available in search results view
	 *
	 * @return float
	*/
	public function getGrundflaeche() {
		return (float) $this->xml->grundflaeche;
	}

	/**
	 * returns the path of the first image
	 *
	 * Only available in search results view
	 *
	 * @return string
	 */
	public function getErstes_bild() {
		return (string) $this->xml->erstes_bild;
	}

	/* list information getters - END */

	/* detail information getters - START */

	/**
	 * returns amount of attachments (images)
	 *
	 * Only available in detail view
	 *
	 * @return integer
	 */
	public function getNbAnhaenge() {
		return count((array) $this->xml->anhaenge);
	}

	/**
	 * returns a normalized version of the attachment (images) objects
	 * 
	 * Only available in detail view
	 *
	 * @return array
	 */
	public function getAnhaenge() {
		$anhaengeInternal = (array) $this->xml->anhaenge;

		// SimpleXML workaround if only one element is in xml
		if ($anhaengeInternal['anhang'] instanceof SimpleXMLElement) {
			$anhaengeInternal['anhang'] = array($anhaengeInternal['anhang']);
		}

		$anhaenge = array();
		// simple but sufficient mapping of attachment data
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

	/**
	 * returns amount of documents (PDF files etc.)
	 *
	 * Only available in detail view
	 *
	 * @return integer
	 */
	public function getNbDokumente() {
		return count((array) $this->xml->dokumente);
	}

	/**
	 * returns documents a normalized version of document objects
	 *
	 * Only available in detail view
	 *
	 * @return array
	 */
	public function getDokumente() {
		$dokumenteInternal = (array)$this->xml->dokumente;

		//SimpleXML workaround if only one element is returned
		if($dokumenteInternal['dokument'] instanceof SimpleXMLElement) {
			$dokumenteInternal['dokument'] = array($dokumenteInternal['dokument']);
		}

		// simple, but sufficient mapping of document data
		$dokumente = array();
		foreach($dokumenteInternal['dokument'] as $dokument) {
			$dokumente[] = array(
				'titel'  => (string)$dokument->titel,
				'pfad'   => (string)$dokument->pfad,
				'format' => (string)$dokument->format
			);
		}

		return $dokumente;
	}

	/**
	 * returns the object type in string representation
	 *
	 * Only available in detail view
	 *
	 * @return string
	 */
	public function getObjektart() {
		return (string) $this->xml->objektkategorie->objektart->children()->getName();
	}

	/**
	 * returns the normalized object type string representation
	 *
	 * Only available in detail view
	 *
	 * @return string either "Haus" or "Wohnung"
	 */
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

	/**
	 * returns the amount of usage types
	 *
	 * Only available in detail view
	 *
	 * @return integer
	 */
	public function getNbNutzungsart() {
		return (integer) count($this->xml->objektkategorie->nutzungsart);
	}

	/**
	 * flags, if the usage type is set to "WOHNEN"
	 *
	 * Only available in detail view
	 *
	 * @return boolean
	 */
	public function getIsNutzungsartWohnen() {
		return $this->xml->objektkategorie->nutzungsart['WOHNEN'] == 1;
	}

	/**
	 * flags, if the usage type is set to "GEWERBE"
	 *
	 * Only available in detail view
	 *
	 * @return boolean
	 */
	public function getIsNutzungsartGewerbe() {
		return $this->xml->objektkategorie->nutzungsart['GEWERBE'] == 1;
	}

	/**
	 * flags, if the usage type is set to "ANLAGE"
	 *
	 * Only available in detail view
	 *
	 * @return boolean
	 */
	public function getIsNutzungsartAnlage() {
		return $this->xml->objektkategorie->nutzungsart['ANLAGE'] == 1;
	}

	/**
	 * returns the external object number from "verwaltung_techn" information array
	 *
	 * Only available in detail view
	 *
	 * @return string
	 */
	public function getObjektnrExtern() {
		return (string) $this->xml->verwaltung_techn->objektnr_extern;
	}

	/**
	 * returns the internal object number from "verwaltung_techn" information array
	 *
	 * Only available in detail view
	 *
	 * @return string
	 */
	public function getObjektnrIntern() {
		return (string) $this->xml->verwaltung_techn->objektnr_intern;
	}

	/**
	 * returns the normalized price information array
	 *
	 * Only available in detail view
	 *
	 * @return array
	 */
	public function getPreise() {
		return (array) $this->xml->preise;
	}

	/**
	 * returns the net rent
	 *
	 * Only available in detail view. First checks if the "nettokaltmiete" property
	 * is available. If not, fallback to "kaltmiete" property.
	 *
	 * @return float
	 */
	public function getNettomiete() {
		$returnValue = 0.0;

		if (isset($this->xml->preise->nettokaltmiete) && $this->xml->preise->nettokaltmiete > 0) {
			$returnValue = (float) $this->xml->preise->nettokaltmiete;
		} elseif ($this->xml->preise->kaltmiete) {
			$returnValue = (float) $this->xml->preise->kaltmiete;
		}

		return $returnValue;
	}

	/**
	 * return the running costs
	 *
	 * @return float|null
	 */
	public function getBetriebskosten()	{
		$returnValue = null;

		if (isset($this->xml->preise->zusatzkosten) && isset($this->xml->preise->zusatzkosten->betriebskosten)) {
			$returnValue = (array) $this->xml->preise->zusatzkosten->betriebskosten;
		}

		return $returnValue;
	}

	/**
	 * flags if the equipment features property is available
	 *
	 * Only available in detail view
	 *
	 * @param integer $minimumLength defines how many chars the equipment features string must consist of
	 * @return boolean
	 */
	public function getHasAusstattungsBeschreibung($minimumLength = 2) {
		if (strlen(trim($this->xml->freitexte->ausstatt_beschr)) > $minimumLength) {
			return TRUE;
		}

		return FALSE;
	}

	/**
	 * flags, if the "tel_zentrale" property is set in the "kontaktperson" information array
	 *
	 * Only available in detail view
	 *
	 * @return boolean
	 */
	public function getHasTelefonZentrale() {
		return ($this->xml->kontaktperson->tel_zentrale && $this->xml->kontaktperson->tel_zentrale != 0);
	}

	/**
	 * flags if the "tel_handy" property is set in the "kontaktperson" information array
	 *
	 * Only available in detail view
	 *
	 * @return boolean
	 */
	public function getHasTelefonHandy() {
		return ($this->xml->kontaktperson->tel_handy && $this->xml->kontaktperson->tel_handy != 0);
	}

	/**
	 * flags if the "tel_fax" property is set in the "kontaktperson" information array
	 *
	 * Only available in detail view
	 *
	 * @return boolean
	 */
	public function getHasFax() {
		return ($this->xml->kontaktperson->tel_fax && $this->xml->kontaktperson->tel_fax != 0);
	}

	/**
	 * returns a normalized geo information array
	 *
	 * Only available in detail view
	 *
	 * @return array
	 */
	public function getGeo() {
		return (array) $this->xml->geo;
	}

	/**
	 * returns a normalized "free texts" information array
	 *
	 * Only available in detail view
	 *
	 * @return array
	 */
	public function getFreitexte() {
		return (array) $this->xml->freitexte;
	}

	/**
	 * returns the freitexte.lage information in detail view and the naehe information in list view (inconsistency in api)
	 *
	 * @return string
	 */
	public function getNaehe() {
		if (isset($this->xml->freitexte)) {
			return (string) $this->xml->freitexte->lage;
		}

		return isset($this->xml->naehe) ? (string) $this->xml->naehe : "";
	}

	/**
	 * returns the property "objekttitel" from "freitexte" subproperty
	 *
	 * Only available in detail view
	 *
	 * @return string
	 */
	public function getObjekttitel() {
		return (string) $this->xml->freitexte->objekttitel;
	}

	/**
	 * returns a normalized information array about the realty object's state
	 * 
	 * Only available in detail view
	 *
	 * @return array
	 */
	public function getZustand_angaben() {
		return (array) $this->xml->zustand_angaben;
	}

	/**
	 * returns a normalized information array about the realty's areas
	 *
	 * Only available in detail view
	 *
	 * @return array
	 */
	public function getFlaechen() {
		return (array) $this->xml->flaechen;
	}

	/**
	 * returns a normalized information array about the realty's contact person
	 *
	 * Only available in detail view
	 *
	 * @return array
	 */
	public function getKontaktperson() {
		return (array) $this->xml->kontaktperson;
	}

	/**
	 * returns a normalized information array about the "verwaltung_techn" property
	 *
	 * Only available in detail view
	 *
	 * @return array
	 */
	public function getVerwaltung_techn() {
		return (array) $this->xml->verwaltung_techn;
	}

	/**
	 * returns a boolean flag which determines if the current detail object has geographical coordinates
	 *
	 * @return boolean
	 */
	public function getHasGeokoordinaten() {
		$geo = $this->getGeo();
		return isset($geo['geokoordinaten']);
	}

	/**
	 * returns the latitude
	 *
	 * returns 0 if self::getHasGeokoordinaten() returns FALSE
	 *
	 * @return float
	 */
	public function getBreitengrad() {
		if (!$this->getHasGeokoordinaten()) {
			return 0.0;
		}

		$geo = $this->getGeo();

		return (float) $geo['geokoordinaten']['breitengrad'];
	}

	/**
	 * returns the longitude
	 *
	 * returns 0 if self::getHasGeokoordinaten() returns FALSE
	 *
	 * @return flaot
	 */
	public function getLaengengrad() {
		if (!$this->getHasGeokoordinaten()) {
			return 0.0;
		}

		$geo = $this->getGeo();

		return (float) $geo['geokoordinaten']['laengengrad'];
	}
	/* detail information getters - END */
}
?>
