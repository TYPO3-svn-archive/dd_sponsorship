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
class Tx_DdSponsorship_Domain_Model_SponsorshipLink extends Tx_Extbase_DomainObject_AbstractValueObject {

	/**
	 * pate
	 *
	 * @var integer
	 */
	protected $pate;

	/**
	 * patenKind
	 *
	 * @var integer
	 */
	protected $patenKind;

	/**
	 * status
	 *
	 * @var integer
	 */
	protected $status;

	/**
	 * Returns the pate
	 *
	 * @return integer $pate
	 */
	public function getPate() {
		return $this->pate;
	}

	/**
	 * Sets the pate
	 *
	 * @param integer $pate
	 * @return void
	 */
	public function setPate($pate) {
		$this->pate = $pate;
	}

	/**
	 * Returns the patenKind
	 *
	 * @return integer patenKind
	 */
	public function getPatenKind() {
		return $this->patenKind;
	}

	/**
	 * Sets the patenKind
	 *
	 * @param integer $patenKind
	 * @return integer patenKind
	 */
	public function setPatenKind($patenKind) {
		$this->patenKind = $patenKind;
	}

	/**
	 * Returns the status
	 *
	 * @return integer status
	 */
	public function getStatus() {
		return $this->status;
	}

	/**
	 * Sets the status
	 *
	 * @param integer $status
	 * @return integer status
	 */
	public function setStatus($status) {
		$this->status = $status;
	}

}
?>