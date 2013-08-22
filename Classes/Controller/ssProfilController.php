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
 * Add informations to a profile.
 *
 * @author duda|design GbR
 * @version 1.0
 *
 */
class Tx_DdSponsorship_Controller_ssProfilController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * sponsorshipKonfigurationRepository
	 *
	 * @var Tx_DdSponsorship_Domain_Repository_SponsorshipKonfigurationRepository
	 */
	protected $sponsorshipKonfigurationRepository;

	/**
	 * Sending informations into form
	 *
	 * @param array $ms Contains error messages
	 * @return void
	 */
	public function indexAction(array $ms = NULL) {

		//Ruft die aktuelle Session User ID auf.
		$uid = $GLOBALS['TSFE'] -> fe_user -> user[uid];
		$this -> cacheService -> clearPageCache($pidList);

		//Holt sich alle Datensätze aus der Config Tabelle
		$this -> sponsorshipKonfigurationRepository = t3lib_div::makeInstance('Tx_DdSponsorship_Domain_Repository_SponsorshipKonfigurationRepository');
		$getUserInfo = $this -> sponsorshipKonfigurationRepository -> getUserInfo($uid);

		$isPate = $this -> sponsorshipKonfigurationRepository -> getAllePaten($uid);

		if ($isPate[0][fuid] != "") {
			$this -> view -> assign('pate', "1");

		} else {
			$this -> view -> assign('patenkind', "1");
		}

		if ($ms[ms] == "1") {
			$this -> view -> assign('ms', Tx_Extbase_Utility_Localization::translate(page_profil_edit_MS_ok, DdSponsorship));
		}
		$this -> view -> assign('entry', $getUserInfo);
	}

	/**
	 * Update an user.
	 *
	 * @param array global Contains form informations
	 * @return void
	 */
	public function submitAction(array $global = NULL) {

		$uid = $GLOBALS['TSFE'] -> fe_user -> user[uid];
		$this -> sponsorshipKonfigurationRepository = t3lib_div::makeInstance('Tx_DdSponsorship_Domain_Repository_SponsorshipKonfigurationRepository');
		$getUserInfo = $this -> sponsorshipKonfigurationRepository -> UpdateUser($uid, $global);

		$done = "1";

		//Meldungen generieren
		$ms = array("ms" => $done, "er" => $error);
		$this -> redirect('index', 'ssProfil', NULL, array('ms' => $ms));
	}

}
?>