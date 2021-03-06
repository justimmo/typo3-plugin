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
 * Test case for class Tx_Justimmo_Domain_Model_Filter.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage justimmo.at Real estate plugin
 *
 * @author Thomas Juhnke <tommy@van-tomas.de>
 */
class Tx_Justimmo_Domain_Model_FilterTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_Justimmo_Domain_Model_Filter
	 */
	protected $fixture;

	/**
	 * an array of price values
	 *
	 * Second array level, where value at index 0 is input value, index 1 is expected output value
	 *
	 * @var array
	 */
	protected $validPriceValues;

	public function setUp() {
		$this->fixture = new Tx_Justimmo_Domain_Model_Filter();

		$this->priceValues = array(
			array('1.234,56', 1234.56),
			array('0', (float) 0),
			array('100.000.123,75', 100000123.75),
			array('10\'000.2', 10000.2),
			array(1.23, 1.23),
			array(1.23456789, 1.23456789),
			array(+123.45, 123.45),
			array(-123.45, -123.45),
			array('+123,45', 123.45),
			array('-123,4567', -123.4567),
			array('1230,5 €', 1230.5),
			array('$ 1,000.23', 1000.23),
			array(100, (float) 100),
			array('12345', (float) 12345),
			array(NULL, (float) 0),
			array(FALSE, (float) 0),
			array(TRUE, (float) 0),
			array('arbitrary string value', (float) 0),
			array('1234,56-', 1234.56),
			array('$(%)§?µ', (float) 0)
		);
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getObjektnummerReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getObjektnummer()
		);
	}

	/**
	 * @test
	 */
	public function setObjektnummerForIntegerSetsObjektnummer() { 
		$this->fixture->setObjektnummer(12);

		$this->assertSame(
			12,
			$this->fixture->getObjektnummer()
		);
	}
	
	/**
	 * @test
	 */
	public function getKaufReturnsInitialValueForBoolean() { 
		$this->assertSame(
			TRUE,
			$this->fixture->getKauf()
		);
	}

	/**
	 * @test
	 */
	public function setKaufForBooleanSetsKauf() { 
		$this->fixture->setKauf(TRUE);

		$this->assertSame(
			TRUE,
			$this->fixture->getKauf()
		);
	}
	
	/**
	 * @test
	 */
	public function getMieteReturnsInitialValueForBoolean() { 
		$this->assertSame(
			TRUE,
			$this->fixture->getMiete()
		);
	}

	/**
	 * @test
	 */
	public function setMieteForBooleanSetsMiete() { 
		$this->fixture->setMiete(TRUE);

		$this->assertSame(
			TRUE,
			$this->fixture->getMiete()
		);
	}
	
	/**
	 * @test
	 */
	public function getObjektartIdReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getObjektartId()
		);
	}

	/**
	 * @test
	 */
	public function setObjektartIdForIntegerSetsObjektartId() { 
		$this->fixture->setObjektartId(12);

		$this->assertSame(
			12,
			$this->fixture->getObjektartId()
		);
	}
	
	/**
	 * @test
	 */
	public function getPreisVonReturnsInitialValueForFloat() { 
		$this->assertSame(
			0.0,
			$this->fixture->getPreisVon()
		);
	}

	/**
	 * @test
	 */
	public function setPreisVonForFloatSetsPreisVon() { 
		$this->fixture->setPreisVon(3.14159265);

		$this->assertSame(
			3.14159265,
			$this->fixture->getPreisVon()
		);
	}

	/**
	 * @test
	 */
	public function setPreisVonValueForValidPriceValueSetsPreisVon() {
		$i = 0;
		foreach ($this->priceValues as $priceValue) {
			$inputValue = $priceValue[0];
			$outputValue = $priceValue[1];
			$this->fixture->setPreisVon($inputValue);

			$expectedValue = $this->fixture->getPreisVon();
			$this->assertSame(
				$outputValue, 
				$expectedValue, 
				sprintf("%s input (%s), %s was expected, but %s was returned",
					var_export($inputValue, true),
					$i,
					var_export($outputValue, true),
					var_export($expectedValue, true)
				)
			);
			$i++;
		}
	}

	/**
	 * @test
	 */
	public function getPreisBisReturnsInitialValueForFloat() { 
		$this->assertSame(
			0.0,
			$this->fixture->getPreisBis()
		);
	}

	/**
	 * @test
	 */
	public function setPreisBisForFloatSetsPreisBis() { 
		$this->fixture->setPreisBis(3.14159265);

		$this->assertSame(
			3.14159265,
			$this->fixture->getPreisBis()
		);
	}
	
	/**
	 * @test
	 */
	public function getZimmerVonReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getZimmerVon()
		);
	}

	/**
	 * @test
	 */
	public function setZimmerVonForIntegerSetsZimmerVon() { 
		$this->fixture->setZimmerVon(12);

		$this->assertSame(
			12,
			$this->fixture->getZimmerVon()
		);
	}
	
	/**
	 * @test
	 */
	public function getZimmerBisReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getZimmerBis()
		);
	}

	/**
	 * @test
	 */
	public function setZimmerBisForIntegerSetsZimmerBis() { 
		$this->fixture->setZimmerBis(12);

		$this->assertSame(
			12,
			$this->fixture->getZimmerBis()
		);
	}
	
	/**
	 * @test
	 */
	public function getWohnflaecheVonReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getWohnflaecheVon()
		);
	}

	/**
	 * @test
	 */
	public function setWohnflaecheVonForIntegerSetsWohnflaecheVon() { 
		$this->fixture->setWohnflaecheVon(12);

		$this->assertSame(
			12,
			$this->fixture->getWohnflaecheVon()
		);
	}
	
	/**
	 * @test
	 */
	public function getWohnflaecheBisReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setWohnflaecheBisForStringSetsWohnflaecheBis() { 
		$this->fixture->setWohnflaecheBis('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getWohnflaecheBis()
		);
	}
	
	/**
	 * @test
	 */
	public function getPlzVonReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setPlzVonForStringSetsPlzVon() { 
		$this->fixture->setPlzVon('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getPlzVon()
		);
	}
	
	/**
	 * @test
	 */
	public function getPlzBisReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setPlzBisForStringSetsPlzBis() { 
		$this->fixture->setPlzBis('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getPlzBis()
		);
	}
	
	/**
	 * @test
	 */
	public function getOrtReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setOrtForStringSetsOrt() { 
		$this->fixture->setOrt('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getOrt()
		);
	}
	
	/**
	 * @test
	 */
	public function getLandIdReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getLandId()
		);
	}

	/**
	 * @test
	 */
	public function setLandIdForIntegerSetsLandId() { 
		$this->fixture->setLandId(12);

		$this->assertSame(
			12,
			$this->fixture->getLandId()
		);
	}
	
	/**
	 * @test
	 */
	public function getBundeslandIdReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getBundeslandId()
		);
	}

	/**
	 * @test
	 */
	public function setBundeslandIdForIntegerSetsBundeslandId() { 
		$this->fixture->setBundeslandId(12);

		$this->assertSame(
			12,
			$this->fixture->getBundeslandId()
		);
	}
	
	/**
	 * @test
	 */
	public function getRegionReturnsInitialValueForInteger() { 
		$this->assertSame(
			0,
			$this->fixture->getRegion()
		);
	}

	/**
	 * @test
	 */
	public function setRegionForIntegerSetsRegion() { 
		$this->fixture->setRegion(12);

		$this->assertSame(
			12,
			$this->fixture->getRegion()
		);
	}
	
}
?>