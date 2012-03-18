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
 * justimmo.at API service
 * 
 *
 * @package justimmo
 * @subpackage Service
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class Tx_Justimmo_Service_JustimmoApiService implements t3lib_Singleton {

	/**
	 * base URL of the API service
	 *
	 * @var string
	 */
	protected $baseUrl = 'http://api.justimmo.at/rest/v1';

	/**
	 * username
	 *
	 * @var string
	 */
	protected $username = '';

	/**
	 * password
	 *
	 * @var string
	 */
	protected $password = '';

	/**
	 * debug flag
	 *
	 * @var boolean
	 */
	protected $debug = FALSE;

    /**
     * injects the API configuration
     *
     * This injection method also sets the username, password and baseUrl for the API.
     *
     * @param Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager
     * @return void
     */
	public function injectConfigurationManager(Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager) {
		$configuration = $configurationManager->getConfiguration(Tx_Extbase_Configuration_ConfigurationManager::CONFIGURATION_TYPE_SETTINGS);
		$apiConfiguration = $configuration['api'];

		$this->username = $apiConfiguration['username'];
		$this->password = $apiConfiguration['password'];

		if ('' !== trim($apiConfiguration['baseUrl'])) {
			$this->baseUrl = $apiConfiguration['baseUrl'];
		}
	}

    /**
     * sets the debug flag
     *
     * @param boolean $state
     * @return void
     */
	public function setDebug($state = TRUE) {
		$this->debug = $state;
	}

	/**
	 * fetches the data from the API endpoint
	 *
	 * @param string $url
	 * @return string the API response (XML string, binary stream (expose PDF))
	 */
	public function loadData($url) {
		$ch = curl_init();

		//die($this->baseUrl . $url);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $this->baseUrl . $url);
		curl_setopt($ch, CURLOPT_USERPWD, $this->username . ':' . $this->password);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);

		if ($this->debug) {
			echo "Fetch: " . $url;
		}

		$result = curl_exec($ch);

		curl_close($ch);

		if ($this->debug) {
			echo "Fetch-Result: " . $result;
		}

		return $result;
	}

	/**
	 * returns the API response as a SimpleXMLElement
	 *
	 * @param string $url
	 * @return SimpleXMLElement
	 */
	public function getData($url) {
		return simplexml_load_string($this->loadData($url));
	}

	/**
	 * fetches a list of realty objects
	 *
	 * @param array $params API endpoint parameters
	 * @param array $filter API endpoint filter configuration
	 * @param string $orderby a valid API endpoint ordering key (e.g. "ort", "land" etc.)
	 * @param integer $offset sets the offset of the list (for paging)
	 * @param integer $limit limits the return realty objects
	 * @return SimpleXMLElement
	 */
	public function getList($params = array(), $filter = array(), $orderby = NULL, $offset = 0, $limit = 0) {
		if (is_array($filter)) {
			foreach ($filter as $key => $value) {
				if (is_array($value)) {
					foreach ($value as $key1 => $value1) {
						$params[] = 'filter[' . $key . '][]=' . $value1;
					}
				} else {
					$params[] = 'filter[' . $key . ']=' . $value;
				}
			}
		}

		if ($orderby) {
			$params[] = 'orderby=' . $orderby;
		}

        if ($offset) {
			$params[] = 'offset=' . $offset;
		}

		if ($limit) {
			$params[] = 'limit=' . $limit;
		}

		return new SimpleXMLElement($this->loadData('/objekt/list?' . implode('&', $params)));
    }

    /**
     * fetchs realty object detail info
     *
     * @param integer $id the realty object id
     * @return SimpleXMLElement
     */
    public function getDetail($id) {
		return $this->getData('/objekt/detail/objekt_id/' . $id);
	}

	/**
	 * fetches the team list info
	 *
	 * @return SimpleXMLElement
	 */
	public function getTeamList() {
		return $this->getData('/team/list');
	}

	/**
	 * loads the expose PDF stream for a given realty object id
	 *
	 * @param integer $id
	 * @return string the binary expose PDF stream
	 */
	public function getExpose($id) {
		return $this->loadData('/objekt/expose?objekt_id=' . $id);
	}

	/**
	 * returns a list of countries from the API
	 *
	 * only countries where active objects exists are returned
	 *
	 * @return SimpleXMLElement
	 * @author Thomas Juhnke <tommy@van-tomas.de>
	 */
	public function getCountries() {
		return $this->getData('/objekt/laender');
	}

	/**
	 * returns a list of subdivisions (states/"bundesländer") from the API
	 *
	 * only subdivision where active objects exists are returned
	 *
	 * @param mixed $countryIdent either the country ID or a valid ISO2 country code
	 * @return SimpleXMLElement
	 * @author Thomas Juhnke <tommy@van-tomas.de>
	 */
	public function getSubDivisions($countryIdent = NULL) {
		$params = '';

		if (NULL !== $countryIdent) {
			$params = '?land=' . $countryIdent;
		}

		return $this->getData('/objekt/bundeslaender' . $params);
	}

	/**
	 * convenience method for self::getSubdivisions
	 *
	 * (non-PHPdoc)
	 * @see self::getSubdivisions
	 */
	public function getStates($countryIdent = NULL) {
		return $this->getSubDivisions($countryIdent);
	}

	/**
	 * fetches a list of regions for a given country OR subdivision
	 *
	 * $subdivision has a higher priority than country, if it is set, countryIdent
	 * is ignored.
	 *
	 * @param mixed $countryIdent either a country ID or a valid ISO2 country code
	 * @param integer $subdivisionId a subdivision ID
	 * @return SimpleXMLElement
	 * @author Thomas Juhnke <tommy@van-tomas.de>
	 */
	public function getRegions($countryIdent = NULL, $subdivisionId = NULL) {
		$params = '';

		if (NULL !== $countryIdent) {
			$params = '?land=' . $countryIdent;
		}

		if (NULL !== $subdivisionId) {
			$params = '?bundesland=' . $subdivisionId;
		}

		return $this->getData('/objekt/regionen' . $params);
	}
}
?>