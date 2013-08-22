<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2013 
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
 * @package dd_sponsorship
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_DdSponsorship_Domain_Model_SponsorshipKonfiguration extends Tx_Extbase_DomainObject_AbstractValueObject {

	/**
	 * pateId
	 *
	 * @var integer
	 * @validate NotEmpty
	 */
	protected $pateId;

	/**
	 * patenKindId
	 *
	 * @var integer
	 * @validate NotEmpty
	 */
	protected $patenKindId;

	/**
	 * Returns the pateId
	 *
	 * @return integer $pateId
	 */
	public function getPateId() {
		return $this->pateId;
	}

	/**
	 * Sets the pateId
	 *
	 * @param integer $pateId
	 * @return void
	 */
	public function setPateId($pateId) {
		$this->pateId = $pateId;
	}

	/**
	 * Returns the patenKindId
	 *
	 * @return integer $patenKindId
	 */
	public function getPatenKindId() {
		return $this->patenKindId;
	}

	/**
	 * Sets the patenKindId
	 *
	 * @param integer $patenKindId
	 * @return void
	 */
	public function setPatenKindId($patenKindId) {
		$this->patenKindId = $patenKindId;
	}

}
?>